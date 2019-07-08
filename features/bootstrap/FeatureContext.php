<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Supermarket\Application\Calculator\GrandTotalCalculator;
use Supermarket\Exception\ProductNotFoundException;
use Supermarket\Model\Cart;
use Supermarket\Model\Product;
use Supermarket\Testing\Application\TestingServiceContainer;
use Supermarket\Testing\Repository\MemoryBasedProductRepository;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    /** @var Cart */
    private $cart;

    /** @var MemoryBasedProductRepository */
    private $productRepository;

    /** @var GrandTotalCalculator */
    private $calculator;

    public function __construct()
    {
        $serviceContainer = new TestingServiceContainer();

        $this->cart = $serviceContainer->getCartRepository()->getById(null);

        $this->productRepository = $serviceContainer->getProductRepository();

        $this->calculator = $serviceContainer->getGrandTotalCalculator();
    }

    /**
     * @Given the following products exists:
     *
     * @param TableNode $table
     */
    public function theFollowingProductsExists(TableNode $table)
    {
        foreach ($table as $item) {
            $product = new Product($item['product_id'], $item['product_name'], $item['product_price'],
                $item['product_type']);
            $this->productRepository->addProduct($product);
        }
    }

    /**
     * @Then I should have :quantity product in my repository
     *
     * @param $quantity
     *
     * @return bool
     * @throws Exception
     */
    public function iShouldHaveProductInMyRepository($quantity)
    {
        if ($quantity != count($this->productRepository->getAllProducts())) {
            throw new Exception ('Wrong number of product in the repository');
        }

        return true;
    }

    /**
     * @Given It is :dayOfWeek
     *
     * @param $dayOfWeek
     *
     * @return bool
     * @throws Exception
     */
    public function itIsMonday($dayOfWeek)
    {
        $success = date('l') === $dayOfWeek;

        if ($success) {
            return true;
        } else {
            throw new Exception(sprintf('It is not %s', $dayOfWeek));
        }
    }

    /**
     * @Given It is not :dayOfWeek
     *
     * @param $dayOfWeek
     *
     * @return bool
     * @throws Exception
     */
    public function itIsNot($dayOfWeek)
    {
        $success = !date('l') !== $dayOfWeek;

        if ($success) {
            return true;
        } else {
            throw new Exception(sprintf('It is %s', $dayOfWeek));
        }
    }

    /**
     * @Given I have no items in my cart
     */
    public function iHaveNoItemsInMyCart()
    {
        if (empty($this->cart->getItems())) {
            return true;
        } else {
            throw new Exception('I already have items in my cart.');
        }
    }

    /**
     * @Transform :product
     *
     * @param string $productName
     *
     * @return Product
     * @throws ProductNotFoundException
     */
    public function castProductNameToProduct(string $productName)
    {
        return $this->productRepository->getProductByName($productName);
    }

    /**
     * @When I add :quantity :product to my cart
     *
     * @param $quantity
     * @param $product
     *
     */
    public function iAddProductToMyCart($quantity, $product)
    {
        $this->cart->addProduct($product, $quantity);
    }

    /**
     * @Then I should have :items items in my cart
     *
     * @param $items
     *
     * @return bool
     * @throws Exception
     */
    public function iShouldHaveItemsInMyCart($items)
    {
        $cartItems = 0;
        foreach ($this->cart->getItems() as $item) {
            $cartItems += $item->getQuantity();
        }
        if ($cartItems == $items) {
            return true;
        } else {
            throw new Exception(sprintf('I have %s item(s) in my cart.', $cartItems));
        }
    }

    /**
     * @Then The total cost of my cart will be :expectedCost
     *
     * @param $expectedCost
     *
     * @return bool
     * @throws Exception
     */
    public function theTotalCostOfMyCartWillBe($expectedCost)
    {
        $cost = $this->calculator->getTotal($this->cart);
        $cost = $cost['Grand Total']->getSum();
        if ($cost == $expectedCost) {
            return true;
        } else {
            throw new Exception(sprintf('Grand total should be "%s", not "%s"', $expectedCost, $cost));
        }
    }

    /**
     * @When I try add a non-existent item to my cart
     *
     * @return bool
     * @throws Exception
     */
    public function iAddANonExistentItemToMyCart()
    {
        $success = false;

        $nonExistentId = count($this->productRepository->getAllProducts()) + 1;
        try {
            $this->productRepository->getProductById($nonExistentId);
        } catch (ProductNotFoundException $exception) {
            $success = true;
        }

        return $success;
    }

    /**
     * @Then I should get Product not found error.
     *
     * @return bool
     * @throws Exception
     */
    public function iShouldGetProductNotFoundError()
    {
        $error = $this->iAddANonExistentItemToMyCart();
        if ($error) {
            return true;
        }
        throw new Exception('Test failed, product exists');
    }
}
