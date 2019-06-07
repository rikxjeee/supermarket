<?php
require 'vendor/autoload.php';

use Supermarket\Datastore\Credentials;
use Supermarket\Datastore\ProductDatabase;
use Supermarket\Renderer\HTMLrenderer;
use Supermarket\Supermarket;

$content = file_get_contents('./index.html');
$credentials = new Credentials();
$productStorage = new ProductDatabase();
$renderer = new HTMLrenderer();
$app = new Supermarket($credentials, $productStorage, $renderer);
$pages = ['products', 'details', ''];

if (in_array($_GET['page'], $pages)){
    switch ($_GET['page']) {
        default;
        case 'products';
            http_response_code(200);
            echo str_replace('%CONTENT%', $app->getProductList(), $content);
            break;
        case 'details';
            http_response_code(200);
            echo str_replace('%CONTENT%', $app->getSingleProduct($_GET['id']), $content);
            break;
    }
    }else{
        http_response_code(404);
        echo '404 - requested page not found.';
}
