<?php

namespace Supermarket\Controller;

use Supermarket\Model\Request;
use Supermarket\Model\Response;

interface Controller
{
    public function execute(Request $request): Response;
}
