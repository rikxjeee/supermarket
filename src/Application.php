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
    private $productStorage;

    /**
     * Application constructor.
     * @param ProductStorage $productStorage
     */
    public function __construct(ProductStorage $productStorage)
    {
        $this->userInput = new UserInput($productStorage);
        $this->cart = new Cart;
        $this->productStorage = $productStorage;
    }

    /**
     * @throws Exception
     */
    public function runShopping()
    {
        $products = $this->userInput->getProducts();
        foreach ($products as $product) {
            $this->cart->addItem($product);
        }
        $this->renderCart();
    }

    public function runProductCreate()
    {
        do {
            $product = $this->userInput->readProduct();
            $this->productStorage->addProduct($product);
            $continue = strtolower(readline('Do you want to add more products?(Y/n) ')) != 'n';
        } while ($continue);
    }

    public function runUpdateProduct()
    {
        echo $this->productStorage->getProductList();
        $productList = $this->productStorage->getAll();


        do {
            $id = readline('Choose a product: ');
            if (!array_key_exists(($id - 1), $productList)) {
                throw new Exception('No such product.');
            }

            $product = $this->userInput->readProduct();
            $this->productStorage->modifyProduct($product, $productList[$id-1]->getId());
            $continue = strtolower(readline('Do you want to modify more products?(Y/n) ')) != 'n';
        } while ($continue);
    }

    public function runDeleteProduct()
    {
        echo $this->productStorage->getProductList();

        $productList = $this->productStorage->getAll();

        do {
            $id = readline('Choose a product: ');
            if (!array_key_exists(($id - 1), $productList)) {
                throw new Exception('No such product.');
            }

            $confirm = strtolower(readline("Are you sure to remove " . $productList[$id - 1]->getName() . "?(Y/n)") != 'n');
            if (!$confirm) {
                echo "Aborted.".PHP_EOL;
                exit(0);
            }

            $this->productStorage->deleteProduct($productList[$id-1]->getId());
            $continue = strtolower(readline('Do you want to modify more products?(Y/n) ')) != 'n';
        } while ($continue);

    }

    private function renderCart()
    {
        echo $this->cart;
    }
}