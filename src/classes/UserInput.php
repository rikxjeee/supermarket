<?php

namespace Load\classes;

use Exception;

class UserInput
{
    private $userInput;
    /**
     * @var ProductStorage
     */
    private $productStorage;

    public function __construct(string $userInput)
    {
            $this->userInput = $userInput;
            $this->productStorage = new ProductStorage();
    }

    public function getProducts(): array
    {
        $selectedProducts = [];
        echo 'Choose product:'.PHP_EOL;
        $productList = $this->productStorage->getAll();
        foreach ($productList as $key => $product){

            echo ($key+1) .': '.$product->getName() .' £'.$product->getPrice().PHP_EOL;
        }

        do {
            $productNumber = (int)readline('Product: ');

            if (isset($productList[($productNumber - 1)])){
                $selectedProducts[] = $productList[($productNumber - 1)];
            }

            $continue = strtolower(readline('Do you want to add more items?(Y/n) ')) != 'n';
        } while($continue);

        if (empty($selectedProducts)) {
            throw new Exception('Your cart is empty.');
        }
        return $selectedProducts;
    }

    public function __toString()
    {
        return $this->userInput;
    }
}