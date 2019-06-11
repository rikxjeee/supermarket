<?php

namespace Supermarket;

use Exception;
use PDO;
use Supermarket\Application\Router;
use Supermarket\Controller\PageNotFoundController;
use Supermarket\Controller\ProductDetailsPageController;
use Supermarket\Controller\ProductListPageController;
use Supermarket\Model\DatabaseCredentials;
use Supermarket\Model\Request;
use Supermarket\Model\Response;
use Supermarket\Renderer\HTMLrenderer;
use Supermarket\Repository\DatabaseBasedProductRepository;

class Application
{
    /**
     * @var Router
     */
    private $router;

    public function init()
    {
        try {
            if (!file_exists('./config.php')) {
                throw new Exception('configuration missing');
            }

            $config = require './config.php';
            $dataBaseCredentials = DatabaseCredentials::createFromArray($config['db']['connection'] ?? []);
            $database = new PDO(...$dataBaseCredentials->toPDOConfig());
            $productRepository = new DatabaseBasedProductRepository($database);

            $renderer = new HTMLrenderer($config['templates']['basepath']);

            $this->router = new Router();
            $this->router->register('products', new ProductListPageController($productRepository, $renderer));
            $this->router->register('details', new ProductDetailsPageController($productRepository, $renderer));
            $this->router->register('default', new PageNotFoundController());
            $this->router->register('', new ProductListPageController($productRepository, $renderer));
        } catch (Exception $e) {
            $response = new Response($e->getMessage(), Response::STATUS_SERVER_ERROR);
            http_response_code($response->getStatusCode());
            echo $response->getContent();
        }
    }

    public function run(): void
    {
        try {
            $request = new Request($_GET);
            $response = $this->router->match($request)->execute($request);
        } catch (Exception $e) {
            $response = new Response($e->getMessage(), Response::STATUS_SERVER_ERROR);
        }
        http_response_code($response->getStatusCode());
        echo $response->getContent();
    }
}
