<?php

namespace Supermarket\Repository;

use PDO;
use Supermarket\Model\Cart;

class DatabaseBasedCartRepository implements CartRepository
{
    /** @var PDO */
    private $mySqlConnection;

    /** @var ProductRepository */
    private $productRepository;

    public function __construct(PDO $mySqlConnection, ProductRepository $productRepository)
    {
        $this->mySqlConnection = $mySqlConnection;
        $this->productRepository = $productRepository;
    }

    public function getCartById(?int $id): Cart
    {
        if ($id === null) {
            return new Cart(uniqid());
        }

        $fetchCart = $this->mySqlConnection->prepare(
            'SELECT cart_id, product_id, quantity FROM products_in_cart where cart_id=?'
        );
        $fetchCart->execute([$id]);
        $cartData = $fetchCart->fetchAll(PDO::FETCH_ASSOC);
        $cart = new Cart($id);
        foreach ($cartData as $product) {
            $cart->addProduct($this->productRepository->getProductById($product['product_id']), (int)$product['quantity']);
        }

        return $cart;
    }
}
