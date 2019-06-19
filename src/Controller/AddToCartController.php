<?php

namespace Supermarket\Controller;

use InvalidArgumentException;
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
                ['Location' => $this->urlProvider->getCartUrl()]
            );
        } catch (CouldNotSaveException $e) {
            $this->sessionManager->setValue('error_message', $e->getMessage());
            return new Response(
                '',
                Response::STATUS_SERVER_ERROR,
                ['Location' => $this->urlProvider->getProductUrl($request->getPostParam('product_id'))]
            );
        } catch (InvalidArgumentException | ProductNotFoundException $e) {
            $this->sessionManager->setValue('error_message', $e->getMessage());
            return new Response(
                '',
                Response::STATUS_NOT_FOUND,
                ['Location' => $this->urlProvider->getProductListUrl()]
            );
        }
    }

    public function supports(Request $request): bool
    {
        return self::SUPPORTED_REQUEST == $request->getQueryParam('page');
    }
}
