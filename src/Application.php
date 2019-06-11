<?php

namespace Supermarket;

use Exception;
use InvalidArgumentException;
use PDO;
use PDOException;
use Supermarket\Controller\ProductDetailsPageController;
use Supermarket\Controller\ProductListPageController;
use Supermarket\Datastore\DatabaseCredentials;
use Supermarket\Datastore\DatabaseBasedProductRepository;
use Supermarket\Renderer\HTMLrenderer;

class Application
{
    private $renderer;

    public function __construct()
    {
        $this->renderer = new HTMLrenderer();
    }

    public function run(): void
    {
        $credentials = new DatabaseCredentials();
        $request = new Request($_GET);

        try {
            $database = new PDO(...$credentials->getCredentials());
        }catch (PDOException $e){
            $response = new Response($e->getMessage(), Response::STATUS_SERVER_ERROR);
            $this->sendResponse($response);
        }

        $productRepository = new DatabaseBasedProductRepository($database);

        try {
            switch ($request->get('page')) {
                case null;
                case 'products';
                    $productListPageController = new ProductListPageController($productRepository, $this->renderer);
                    $response = $productListPageController->execute($request);
                    $this->sendResponse($response);
                    break;
                case 'details';
                    $productDetailsPageController = new ProductDetailsPageController($productRepository, $this->renderer);
                    $response = $productDetailsPageController->execute($request);
                    $this->sendResponse($response);
                    break;
                default;
                    $response = new Response('404 - Requested page not found.', Response::STATUS_NOT_FOUND);
                    $this->sendResponse($response);
                    break;
            }
        } catch (InvalidArgumentException $e){
            $productListPageController = new ProductListPageController($productRepository, $this->renderer);
            $response = $productListPageController->execute($request);
            $this->sendResponse($response);
        } catch (Exception $e) {
            $response = new Response($e->getMessage(), Response::STATUS_NOT_FOUND);
            $this->sendResponse($response);
        }
    }

    private function sendResponse(Response $response)
    {
        http_response_code($response->getStatusCode());
        echo  $this->renderer->renderWebPage($response->getContent(), 'index.html');
    }
}
