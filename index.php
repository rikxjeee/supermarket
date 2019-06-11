<?php

require 'vendor/autoload.php';

use Supermarket\Application\ServiceContainer;

if (!file_exists('./config.php')) {
    throw new Exception('configuration missing');
}

(new ServiceContainer(require './config.php'))->getApplication()->run();
