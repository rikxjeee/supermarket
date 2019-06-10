<?php

namespace Supermarket\Controller;

use Supermarket\Request;
use Supermarket\Response;

interface PageController
{
    public function execute(Request $request): Response;
}
