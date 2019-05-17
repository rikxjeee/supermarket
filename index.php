<?php

use Load\classes\Application;
use Load\classes\UserInput;
use Load\classes\Credentials;

require 'vendor/autoload.php';
try {
    $myApp = new Application(new UserInput(new Credentials()));
    $myApp->runApplication();
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}