<?php

namespace App\Controller;

use App\Exception\ProductNotFoundException;
use App\Repository\CartRepository;
use App\Repository\ProductRepository;
use App\Service\Calculator\GrandTotalCalculator;
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
     * @param CartRepository       $cartRepository
     * @param GrandTotalCalculator $calculator
     *
     * @return Response
     */
    public function cart(SessionInterface $session, CartRepository $cartRepository, GrandTotalCalculator $calculator)
    {
        $id = $session->get('cart_id');
        $cart = $cartRepository->getCart($id);
        $session->set('cart_id', $cart->getId());

        if (empty($cart->getItems()))
        {
            return $this->render('cart/empty.html.twig');
        }

        $totals = $calculator->getTotal($cart);
        return $this->render('cart/index.html.twig', [
            'items' => $cart->getItems(),
            'totals' => $totals,
        ]);
    }

    /**
     * @Route("/cart/add", name="cart.add")
     *
     * @param Request           $request
     * @param CartRepository    $cartRepository
     * @param SessionInterface  $session
     * @param ProductRepository $productRepository
     *
     * @return Response
     * @throws ProductNotFoundException
     */
    public function add(
        Request $request,
        CartRepository $cartRepository,
        SessionInterface $session,
        ProductRepository $productRepository
    ) {
        $productId = $request->get('product_id');
        $product = $productRepository->getProductById($productId);
        $cartId = $session->get('cart_id');

        $cart = $cartRepository->getCart($cartId);

        $cart->addProduct($product);
        $cartRepository->save($cart);

        $this->addFlash('notice', sprintf('%s has been added to the cart.', $product->getName()));

        return $this->redirectToRoute('cart.content');
    }
}
