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

    $id = readline('Choose a product for deletion: ');
    if (!array_key_exists(($id - 1), $productList)) {
        echo 'No such product.';
        exit(0);
    }


    $confirm = strtolower(readline("Are you sure to remove " . $productList[$id - 1]->getName() . "?(Y/n)") != 'n');
    if (!$confirm) {
        echo "Aborted.";
        exit(0);
    }


    $productStorage->deleteProduct($productList[$id - 1]->getId());

    $continue = strtolower(readline('Do you want to delete more products?(Y/n) ')) != 'n';
} while ($continue);