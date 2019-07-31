<?php

namespace App\Service\Handler;

use App\Entity\Cart;
use App\Exception\ProductNotFoundException;
use App\Repository\CartRepository;
use App\Repository\ProductRepository;

class CartHandler
{
    /** @var ProductRepository */
    private $productRepository;

    /** @var CartRepository */
    private $cartRepository;

    public function __construct(ProductRepository $productRepository, CartRepository $cartRepository)
    {
        $this->productRepository = $productRepository;
        $this->cartRepository = $cartRepository;
    }

    /**
     * @param int $cartId
     * @param int $productId
     *
     * @return Cart
     * @throws ProductNotFoundException
     */
    public function add(int $cartId, int $productId): Cart
    {
        $cart = $this->cartRepository->getCart($cartId);
        $product = $this->productRepository->getProductById($productId);
        $cart->addProduct($product);
        $this->cartRepository->save($cart);

        return $cart;
    }

    public function get(?int $id): Cart
    {
        return $this->cartRepository->getCart($id);
    }
}
