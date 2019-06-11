<?php

namespace Supermarket\Controller;

use Supermarket\Request;
use Supermarket\Response;

interface Controller
{
    public function execute(Request $request): Response;
}
