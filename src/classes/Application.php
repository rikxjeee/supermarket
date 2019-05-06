<?php

namespace Load\classes;

class Application
{
    private $userInput;
    private $cart;
    private $productStorage;
    public function __construct(UserInput $userInput)
    {
        $this->userInput = $userInput;
        $this->cart = new Cart;
        $this->productStorage = new ProductStorage;
    }

    public function runApplication()
    {
        $products = $this->getProducts();
        foreach ($products as $product) {
            $this->cart->addItem($product);
        }

        $this->renderCart();

    }

    private function getProducts(): array
    {
        $products = [];
        foreach ($this->userInput->getProductNames() as $productName){
            $products[] = $this->productStorage->getByName($productName);
        }
        return $products;
    }

    private function renderCart()
    {
        echo $this->cart;
    }
}