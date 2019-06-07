<?php
namespace Supermarket\Controller;

use Supermarket\Datastore\Credentials;
use Supermarket\Datastore\ProductRepository;
use Supermarket\Renderer\Renderer;
use Supermarket\Request;
use Supermarket\Response;

interface ProductPageController
{
    public function __construct(ProductRepository $productRepository, Credentials $credentials, Renderer $renderer, Request $request);

    public function viewAction(): Response;
}
