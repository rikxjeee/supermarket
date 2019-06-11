<?php

namespace Supermarket;

use Exception;
use Supermarket\Application\Router;
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
            $response = $this
                ->initRouter()
                ->match($request)
                ->execute($request);
        } catch (Exception $e) {
            $response = new Response($e->getMessage(), Response::STATUS_SERVER_ERROR);
        }
        http_response_code($response->getStatusCode());
        echo $response->getContent();
    }

    private function initRouter(): Router
    {
        $router = $this->serviceContainer->getRouter();
        $router->register('products', $this->serviceContainer->getProductListPageController());
        $router->register('details', $this->serviceContainer->getProductDetailsController());
        $router->register('default', $this->serviceContainer->getPageNotFoundController());
        $router->register('', $this->serviceContainer->getProductListPageController());

        return $router;
    }
}
