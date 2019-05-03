<?php

require 'vendor/autoload.php';

try {
    $myApp = new Load\classes\Application($argv, $argc);
    $myApp->runApplication();
} catch (Exception $e) {
    echo $e->getMessage();
}
