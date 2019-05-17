<?php

use Supermarket\Application;
use Supermarket\Datastore\Credentials;
use Supermarket\Datastore\ProductStorage;
use Supermarket\Input\UserInput;

require 'vendor/autoload.php';
try {
    $myApp = new Application(new UserInput(new ProductStorage(new Credentials())));
    $myApp->runApplication();
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}