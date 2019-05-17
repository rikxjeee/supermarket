<?php
require 'vendor/autoload.php';

use Supermarket\Application;
use Supermarket\Datastore\Credentials;
use Supermarket\Datastore\ProductStorage;


$conn = new ProductStorage(new Credentials());

$app = new Application($conn);
try {
    $app->runUpdateProduct();
}catch(Exception $e){
    echo $e->getMessage() . PHP_EOL;
}