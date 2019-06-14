<?php

namespace Supermarket\Controller;

use Supermarket\Model\Request;
use Supermarket\Model\Response;
use Supermarket\Model\Session;

class PageNotFoundController implements Controller
{
    public function execute(Request $request, Session $session): Response
    {
        return new Response('404 - Requested page not found.', Response::STATUS_NOT_FOUND);
    }

    public function supports(Request $request): bool
    {
        return true;
    }
}
