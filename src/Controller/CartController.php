<?php

namespace App\Controller;

use App\Exception\ProductNotFoundException;
use App\Service\Calculator\GrandTotalCalculator;
use App\Service\Handler\CartHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart.content")
     *
     * @param SessionInterface     $session
     * @param CartHandler          $cartHandler
     * @param GrandTotalCalculator $calculator
     *
     * @return Response
     */
    public function cart(SessionInterface $session, CartHandler $cartHandler, GrandTotalCalculator $calculator)
    {
        $id = $session->get('cart_id');
        $cart = $cartHandler->get($id);
        $session->set('cart_id', $cart->getId());

        $totals = $calculator->getTotal($cart);
        return $this->render('cart/index.html.twig', [
            'items' => $cart->getItems(),
            'totals' => $totals,
        ]);
    }

    /**
     * @Route("/cart/add", name="cart.add")
     *
     * @param Request          $request
     * @param CartHandler      $cartHandler
     * @param SessionInterface $session
     *
     * @return Response
     */
    public function add(
        Request $request,
        CartHandler $cartHandler,
        SessionInterface $session
    ) {
        $productId = $request->get('product_id');
        $cartId = $cartHandler->get($session->get('cart_id'))->getId();
        try{
            $cartHandler->add($cartId, $productId);
            $this->addFlash('notice', 'Product has been added to the cart.');
        } catch (ProductNotFoundException $exception) {
            $this->addFlash('warning', 'Product not found.');
        }

        return $this->redirectToRoute('cart.content');
    }
}
