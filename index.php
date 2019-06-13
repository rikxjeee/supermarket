<?php

require 'vendor/autoload.php';

use Supermarket\Application\DefaultServiceContainer;
use Supermarket\Model\Config\ApplicationConfig;

if (!file_exists('./config.php')) {
    throw new Exception('configuration missing');
}

session_start();

(new DefaultServiceContainer(ApplicationConfig::createFromArray(require './config.php')))->getApplication()->run();
