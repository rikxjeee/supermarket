<?php

namespace Supermarket\Application;

use Supermarket\Application;
use Supermarket\Controller\Controller;

interface ServiceContainer
{
    public function getApplication(): Application;

    public function getPageNotFoundController(): Controller;

    public function getProductListPageController(): Controller;

    public function getProductDetailsController(): Controller;

    public function getRouter(): Router;
}
