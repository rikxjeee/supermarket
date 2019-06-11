<?php

namespace Supermarket\Controller;

use Supermarket\Request;
use Supermarket\Response;

class PageNotFoundController implements Controller
{
    public function execute(Request $request): Response
    {
        return new Response('404 - Requested page not found.', Response::STATUS_NOT_FOUND);
    }
}
