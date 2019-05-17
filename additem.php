<?php

use Load\classes\ProductStorage;
use Load\classes\Credentials;
require 'vendor/autoload.php';


$conn = new ProductStorage(new Credentials());

do {
    $continue = true;
    $productName = readline('Product name: ');
    if (strlen($productName) == 0) {
        echo "Product name can't be empty.";
        exit(0);
    }

    $productPrice = readline('Product price: ');
    if (strlen($productName) == 0) {
        echo "Please provide a price for your product.";
        exit(0);
    }

    $productType = readline('Product type: ');
    if (strlen($productName) == 0) {
        echo "Please provide a type for your product.";
        exit(0);
    }

    $conn->addProduct($productName, (float)$productPrice, $productType);
    $continue = strtolower(readline('Do you want to add more products?(Y/n) ')) != 'n';

} while ($continue);