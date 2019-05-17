<?php

use Supermarket\Application;
use Supermarket\Datastore\Credentials;
use Supermarket\Datastore\ProductStorage;

require 'vendor/autoload.php';

$productStorage = new ProductStorage(new Credentials());

try {
    $myApp = new Application($productStorage);
    $myApp->runShopping();
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}