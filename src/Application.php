<?php

namespace Supermarket;

use Exception;
use PDO;
use Supermarket\Controller\ProductDetailsPageController;
use Supermarket\Controller\ProductListPageController;
use Supermarket\Datastore\DatabaseBasedProductRepository;
use Supermarket\Datastore\DatabaseCredentials;
use Supermarket\Renderer\HTMLrenderer;
use Supermarket\Renderer\Renderer;

class Application
{
    /**
     * @var Renderer
     */
    private $renderer;

    public function run(): void
    {
        $request = new Request($_GET);

        try {
            if (!file_exists('./config.php')) {
                throw new Exception('configuration missing');
            }

            $config = require './config.php';
            $dataBaseCredentials = DatabaseCredentials::createFromArray($config['db']['connection'] ?? []);
            $database = new PDO(...$dataBaseCredentials->toPDOConfig());
            $productRepository = new DatabaseBasedProductRepository($database);

            $this->renderer = new HTMLrenderer($config['templates']['basepath']);

            switch ($request->get('page')) {
                case null;
                case 'products';
                    $productListPageController = new ProductListPageController($productRepository, $this->renderer);
                    $response = $productListPageController->execute($request);
                    $this->sendResponse($response);
                    break;
                case 'details';
                    $productDetailsPageController = new ProductDetailsPageController($productRepository,
                        $this->renderer);
                    $response = $productDetailsPageController->execute($request);
                    $this->sendResponse($response);
                    break;
                default;
                    $response = new Response('404 - Requested page not found.', Response::STATUS_NOT_FOUND);
                    $this->sendResponse($response);
                    break;
            }
        } catch (Exception $e) {
            $response = new Response($e->getMessage(), Response::STATUS_SERVER_ERROR);
            http_response_code($response->getStatusCode());
            echo $response->getContent();
        }
    }

    private function sendResponse(Response $response)
    {
        http_response_code($response->getStatusCode());
        echo $this->renderer->renderWebPage($response->getContent(), 'index.html');
    }
}
