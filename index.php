<?php

require 'vendor/autoload.php';

use Supermarket\Application;

$application = new Application();
$application->init();
$application->run();
