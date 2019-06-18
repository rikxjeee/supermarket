<?php

namespace Supermarket\Controller;

use Supermarket\Application\SessionManager;
use Supermarket\Exception\CouldNotSaveException;
use Supermarket\Exception\ProductNotFoundException;
use Supermarket\Model\Request;
use Supermarket\Model\Response;
use Supermarket\Provider\UrlProvider;
use Supermarket\Repository\CartRepository;
use Supermarket\Repository\ProductRepository;

class AddToCartController implements Controller
{
    private const SUPPORTED_REQUEST = 'addtocart';

    /** @var SessionManager */
    private $sessionManager;

    /** @var CartRepository */
    private $cartRepository;

    /** @var ProductRepository */
    private $productRepository;

    /** @var UrlProvider */
    private $urlProvider;

    public function __construct(
        SessionManager $sessionManager,
        CartRepository $cartRepository,
        ProductRepository $productRepository,
        UrlProvider $urlProvider
    ) {
        $this->sessionManager = $sessionManager;
        $this->cartRepository = $cartRepository;
        $this->productRepository = $productRepository;
        $this->urlProvider = $urlProvider;
    }

    public function execute(Request $request): Response
    {
        try {
            $cartId = $this->sessionManager->getValue('cart_id');
            $productId = $request->getPostParam('product_id');
            $quantity = $request->getPostParam('quantity');
            $cart = $this->cartRepository->getById($cartId);
            $cart->addProduct($this->productRepository->getProductById($productId), $quantity);
            $this->cartRepository->save($cart);

            return new Response(
                '',
                Response::STATUS_TEMPORARY_REDIRECT,
                ['Location' => $this->urlProvider->getAddToCartUrl()]
            );
        } catch (CouldNotSaveException $e) {
            return new Response($e->getMessage(), Response::STATUS_SERVER_ERROR);
        } catch (ProductNotFoundException $e) {
            return new Response($e->getMessage(), Response::STATUS_NOT_FOUND);
        }
    }

    public function supports(Request $request): bool
    {
        return self::SUPPORTED_REQUEST == $request->getQueryParam('page');
    }
}
