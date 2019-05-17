<?php

namespace Supermarket\Input;

use Exception;
use Supermarket\Datastore\ProductStorage;
use Supermarket\Product;

class UserInput
{
    /**
     * @var ProductStorage
     */
    private $productStorage;

    /**
     * UserInput constructor.
     * @param ProductStorage $productStorage
     */
    public function __construct(ProductStorage $productStorage)
    {
        $this->productStorage = $productStorage;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getProducts(): array
    {
        $selectedProducts = [];
        echo 'Choose product:' . PHP_EOL;
        $productList = $this->productStorage->getAll();
        foreach ($productList as $key => $product) {
            echo ($key + 1) . ': ' . $product->getName() . ' £' . $product->getPrice() . PHP_EOL;
        }
        do {
            $productNumber = (int)readline('Product: ');
            if (isset($productList[($productNumber - 1)])) {
                $selectedProducts[] = $productList[($productNumber - 1)];
            }
            $continue = strtolower(readline('Do you want to add more items?(Y/n) ')) != 'n';
        } while ($continue);
        if (empty($selectedProducts)) {
            throw new Exception('Your cart is empty.');
        }
        return $selectedProducts;
    }

    public function readProduct(): Product
    {
        $productName = readline('Product name: ');
        if (strlen($productName) == 0) {
            throw new Exception("Product name can't be empty.");
        }

        $productPrice = readline('Product price: ');
        if (strlen($productName) == 0) {
            throw new Exception("Please provide a price for your product.");
        }

        $productType = readline('Product type: ');
        if (strlen($productName) == 0) {
            throw new Exception( "Please provide a type for your product.");
        }

        return new Product(null, $productName, $productPrice, $productType);
    }
}