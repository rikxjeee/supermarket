<?php

namespace Supermarket\Application;

use Supermarket\Application;

interface ServiceContainer
{
    public function getApplication(): Application;

    public function getRouter(): Router;
}
