<?php

namespace Supermarket\Controller;

use Supermarket\Application\SessionManager;
use Supermarket\Model\Request;
use Supermarket\Model\Response;
use Supermarket\Repository\DatabaseBasedCartRepository;
use Supermarket\Repository\ProductRepository;

class AddToCart implements Controller
{
    private const SUPPORTED_REQUEST = 'addtocart';

    /** @var SessionManager */
    private $sessionManager;

    /** @var DatabaseBasedCartRepository */
    private $databaseBasedCartRepository;

    /** @var ProductRepository */
    private $databaseBasedProductRepository;

    public function __construct(
        SessionManager $sessionManager,
        DatabaseBasedCartRepository $databaseBasedCartRepository,
        ProductRepository $databaseBasedProductRepository
    ) {
        $this->sessionManager = $sessionManager;
        $this->databaseBasedCartRepository = $databaseBasedCartRepository;
        $this->databaseBasedProductRepository = $databaseBasedProductRepository;
    }

    public function execute(Request $request): Response
    {
        $this->sessionManager->start();
        $cartId = $this->sessionManager->getValue('cart_id');
        $productId = $request->getPostParam('productid');
        $quantity = $request->getPostParam('quantity');
        $cart = $this->databaseBasedCartRepository->getById($cartId);
        $this->databaseBasedCartRepository->saveCart($cart, $productId, $quantity);
        return new Response(header('Location: index.php?page=cart'), 302);
    }

    public function supports(Request $request): bool
    {
        return self::SUPPORTED_REQUEST == $request->getQueryParam('page');
    }
}
