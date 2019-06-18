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

    public function getById(?int $id): Cart
    {
        if ($id === null) {
            return new Cart(uniqid());
        }

        $fetchCart = $this->mySqlConnection->prepare(
            'SELECT cart_id, product_id, quantity FROM cartitems where cart_id=?'
        );
        $fetchCart->execute([$id]);
        $cartData = $fetchCart->fetchAll(PDO::FETCH_ASSOC);
        $cart = new Cart($id);
        foreach ($cartData as $product) {
            if ($product['quantity']>0) {
                $cart->addProduct($this->productRepository->getProductById($product['product_id']),
                    $product['quantity']);
            }
        }

        return $cart;
    }

    public function saveCart(Cart $cart, string $productId, string $quantity): void
    {
        $query = $this->mySqlConnection->query(
            sprintf('select * from cartitems where cart_id=%s and product_id=%s', $cart->getCartId(), $productId)
        );
        $query = $query->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($query)) {
            $query = $this->mySqlConnection->prepare(
                'update cartitems set quantity=quantity+? where cart_id=? and product_id=?'
            );
            $query->execute([$quantity, $cart->getCartId(), $productId]);
        } else {
            $query = $this->mySqlConnection->prepare(
                'insert into cartitems values (?,?,?)'
            );
            $query->execute([$cart->getCartId(), $productId, $quantity]);
        }
    }
}
