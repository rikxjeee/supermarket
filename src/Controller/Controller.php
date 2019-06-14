<?php

namespace Supermarket\Controller;

use Supermarket\Model\Request;
use Supermarket\Model\Response;
use Supermarket\Model\Session;

interface Controller
{
    public function execute(Request $request, Session $session): Response;

    public function supports(Request $request): bool;
}
