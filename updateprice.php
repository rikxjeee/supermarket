<?php

use Supermarket\Datastore\Credentials;
use Supermarket\Datastore\ProductStorage;

require 'vendor/autoload.php';

$productStorage = new ProductStorage(new Credentials());

do {
    $productList = $productStorage->getAll();
    foreach ($productList as $key => $product) {
        echo ($key + 1) . ': ' . $product->getName() . ' £' . $product->getPrice() . PHP_EOL;
    }

    $id = readline('Choose a product: ');
    if (!array_key_exists(($id - 1), $productList)) {
        echo 'No such product.';
        exit(0);
    }

    $productPrice = readline('Product price: ');
    if (strlen($productPrice) == 0) {
        echo "Please provide a price for your product.";
        exit(0);
    }

    $productStorage->updatePrice((float)$productPrice, $productList[$id - 1]->getId());
    $continue = strtolower(readline('Do you want to update more products?(Y/n) ')) != 'n';
} while ($continue);