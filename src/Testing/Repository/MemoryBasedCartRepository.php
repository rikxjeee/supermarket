<?php

namespace Supermarket\Testing\Repository;

use Supermarket\Model\Cart;
use Supermarket\Repository\CartRepository;
use Supermarket\Repository\ProductRepository;

class MemoryBasedCartRepository implements CartRepository
{
    /** @var Cart[] */
    private $carts;

    /** @var MemoryBasedProductRepository */
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getById(?int $id): Cart
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
