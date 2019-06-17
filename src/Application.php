<?php

namespace Supermarket;

use Exception;
use Supermarket\Application\Router;
use Supermarket\Model\Request;
use Supermarket\Model\Response;

class Application
{
    /**
     * @var Router
     */
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function run(): void
    {
        try {
            $request = new Request($_GET);
            $response = $this->router
                ->match($request)
                ->execute($request);
        } catch (Exception $e) {
            $response = new Response($e->getMessage(), Response::STATUS_SERVER_ERROR);
        }
        http_response_code($response->getStatusCode());
        echo $response->getContent();
    }
}
