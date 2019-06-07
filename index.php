<?php
require 'vendor/autoload.php';

use Supermarket\Controller\ProductDetailsPageController;
use Supermarket\Controller\ProductListPageController;
use Supermarket\Datastore\Credentials;
use Supermarket\Datastore\DatabaseBasedProductRepository;
use Supermarket\Renderer\HTMLrenderer;
use Supermarket\Request;

$content = file_get_contents('./index.html');
$credentials = new Credentials();
$database = new PDO(...$credentials->getCredentials());
$productRepository = new DatabaseBasedProductRepository($database);
$renderer = new HTMLrenderer();
$request = new Request($_GET);

switch ($_GET['page']) {
    default;
    case 'products';
        $productListPageController = new ProductListPageController($productRepository, $credentials, $renderer, $request);
        $response = $productListPageController->viewAction();
        http_response_code($response->getStatusCode());
        echo $response->getContent();
        break;
    case 'details';
        $productListPageController = new ProductDetailsPageController($productRepository, $credentials, $renderer, $request);
        $response = $productListPageController->viewAction();
        http_response_code($response->getStatusCode());
        echo $response->getContent();
        break;
}
