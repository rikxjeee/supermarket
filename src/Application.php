<?php

namespace Supermarket;

use Exception;
use Supermarket\Application\ServiceContainer;
use Supermarket\Model\Request;
use Supermarket\Model\Response;

class Application
{
    /**
     * @var ServiceContainer
     */
    private $serviceContainer;

    public function __construct(ServiceContainer $serviceContainer)
    {
        $this->serviceContainer = $serviceContainer;
    }

    public function run(): void
    {
        try {
            $request = new Request($_GET);
            $response = $this->serviceContainer
                ->getRouter()
                ->match($request)
                ->execute($request);
        } catch (Exception $e) {
            $response = new Response($e->getMessage(), Response::STATUS_SERVER_ERROR);
        }
        http_response_code($response->getStatusCode());
        echo $response->getContent();
    }
}
