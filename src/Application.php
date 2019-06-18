<?php

namespace Supermarket;

use Exception;
use Supermarket\Application\Router;
use Supermarket\Application\SessionManager;
use Supermarket\Model\Request;
use Supermarket\Model\Response;

class Application
{
    /**
     * @var Router
     */
    private $router;

    /** @var SessionManager */
    private $sessionManager;

    public function __construct(Router $router, SessionManager $sessionManager)
    {
        $this->router = $router;
        $this->sessionManager = $sessionManager;
    }

    public function run(): void
    {
        $this->sessionManager->start();
        try {
            $request = new Request($_GET, $_POST);
            $response = $this->router
                ->match($request)
                ->execute($request);
        } catch (Exception $e) {
            $response = new Response($e->getMessage(), Response::STATUS_SERVER_ERROR);
        }
        http_response_code($response->getStatusCode());
        if ($response->hasHeader()) {
            header($response->getHeader());
        }
        echo $response->getContent();
    }
}
