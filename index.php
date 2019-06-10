<?php
require 'vendor/autoload.php';

use Supermarket\Controller\ProductDetailsPageController;
use Supermarket\Controller\ProductListPageController;
use Supermarket\Datastore\Credentials;
use Supermarket\Datastore\DatabaseBasedProductRepository;
use Supermarket\Renderer\HTMLrenderer;
use Supermarket\Request;
use Supermarket\Response;

$content = file_get_contents('./index.html');
$credentials = new Credentials();
$database = new PDO(...$credentials->getCredentials());
$productRepository = new DatabaseBasedProductRepository($database);
$renderer = new HTMLrenderer();
$request = new Request($_GET);

switch ($request->get('page')) {
    case null;
    case 'products';
        $productListPageController = new ProductListPageController($productRepository, $renderer);
        $response = $productListPageController->execute($request);
        $response->sendResponse($response);
        break;
    case 'details';
        $productDetailsPageController = new ProductDetailsPageController($productRepository, $renderer);
        $response = $productDetailsPageController->execute($request);
        $response->sendResponse($response);
        break;
    default;
        $response = new Response('404 - Requested page not found.', Response::STATUS_NOT_FOUND);
        echo $response->getContent();
        break;
}
