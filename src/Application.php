<?php

namespace Supermarket;

use Exception;
use Supermarket\Cart\Cart;
use Supermarket\Datastore\ProductStorage;
use Supermarket\Input\UserInput;

class Application
{
    /**
     * @var UserInput
     */
    private $userInput;
    /**
     * @var Cart
     */
    private $cart;
    /**
     * @var ProductStorage
     */

    /**
     * Application constructor.
     * @param UserInput $userInput
     */
    public function __construct(UserInput $userInput)
    {
        $this->userInput = $userInput;
        $this->cart = new Cart;
    }

    /**
     * @throws Exception
     */
    public function runApplication()
    {
        $products = $this->userInput->getProducts();
        foreach ($products as $product) {
            $this->cart->addItem($product);
        }
        $this->renderCart();
    }


    private function renderCart()
    {
        echo $this->cart;
    }
}