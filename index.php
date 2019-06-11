<?php

require 'vendor/autoload.php';

use Supermarket\Application\DefaultServiceContainer;
use Supermarket\Model\ApplicationConfig;

if (!file_exists('./config.php')) {
    throw new Exception('configuration missing');
}

(new DefaultServiceContainer(ApplicationConfig::createFromArray(require './config.php')))->getApplication()->run();
