<?php

namespace App\Tests\Behat\Repository;

use App\Entity\Cart;
use App\Repository\CartRepository;
use App\Repository\ProductRepository;

class MemoryBasedCartRepository implements CartRepository
{
    /** @var Cart[] */
    private $carts;

    /** @var ProductRepository */
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getCart(?int $id): Cart
    {
        $cart = null;
        if ($id === null) {
            return new Cart(random_int(1,9999));
        }

        foreach ($this->carts as $currentCart) {
            if ($currentCart->getId() == $id) {
                $cart = $currentCart;
            }
        }

        return $cart;
    }

    /**
     * @param Cart $cart
     */
    public function save(Cart $cart): void
    {
            $this->carts[$cart->getId()] = $cart;
    }
}
