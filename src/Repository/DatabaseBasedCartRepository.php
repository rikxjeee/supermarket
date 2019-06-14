<?php

namespace Supermarket\Repository;

use PDO;
use Supermarket\Model\Cart;
use Supermarket\Model\Product;

class DatabaseBasedCartRepository implements CartRepository
{
    /** @var PDO */
    private $mySqlConnection;

    public function __construct(PDO $mySqlConnection)
    {
        $this->mySqlConnection = $mySqlConnection;
    }

    public function getCartById(int $id): Cart
    {
        $fetchCart = $this->mySqlConnection->prepare(
            'SELECT * FROM products_in_carts
        LEFT JOIN products 
        ON products_in_carts.products_id = products.id where cart_id=?'
        );
        $userHasCart = $fetchCart->execute([$id]);
        if (!$userHasCart) {
            return new Cart($id);
        }
        $cartData = $fetchCart->fetchAll(PDO::FETCH_ASSOC);
        $cart = new Cart($id);
        foreach ($cartData as $product) {
            $cart->addProduct(Product::createFromArray($product));
        }

        return $cart;
    }
}
