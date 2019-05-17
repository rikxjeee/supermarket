<?php

namespace Supermarket\Input;

use Exception;
use Supermarket\Datastore\Credentials;
use Supermarket\Datastore\ProductStorage;

class UserInput
{
    /**
     * @var ProductStorage
     */
    private $productStorage;

    /**
     * UserInput constructor.
     * @param Credentials $credentials
     */
    public function __construct($credentials)
    {
        $this->productStorage = new ProductStorage($credentials);
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
}