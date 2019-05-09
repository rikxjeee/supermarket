<?php

use Load\classes\Application;
use Load\classes\UserInput;

require 'vendor/autoload.php';

try {
    $myApp = new Application(new UserInput());
    $myApp->runApplication();
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}