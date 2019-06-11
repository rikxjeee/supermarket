<?php

namespace Supermarket\Controller;

use Supermarket\Model\Request;
use Supermarket\Model\Response;

class PageNotFoundController implements Controller
{
    public function execute(Request $request): Response
    {
        return new Response('404 - Requested page not found.', Response::STATUS_NOT_FOUND);
    }
}
