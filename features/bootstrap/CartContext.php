<?php

use App\Entity\Cart;
use App\Entity\Product;
use App\Entity\Total;
use App\Exception\ProductNotFoundException;
use App\Repository\CartRepository;
use App\Repository\ProductRepository;
use App\Service\Calculator\GrandTotalCalculator;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class CartContext implements Context
{
    /** @var Cart */
    private $cart;

    /** @var ProductRepository */
    private $productRepository;

    /** @var GrandTotalCalculator */
    private $calculator;

    public function __construct(
        CartRepository $cartRepository,
        ProductRepository $productRepository,
        GrandTotalCalculator $calculator

    ) {
        $this->cart = $cartRepository->getCart(null);

        $this->productRepository = $productRepository;

        $this->calculator = $calculator;
    }

    /**
     * @Given the following products exists:
     *
     * @param TableNode $table
     */
    public function theFollowingProductsExists(TableNode $table)
    {
        foreach ($table as $item) {
            $product = new Product($item['product_name'], $item['product_type'],  $item['product_desc'], $item['product_price'],
                $item['product_id']);
            $this->productRepository->save($product);
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
        /** @var Product[] $products */
        $products = $this->productRepository->getAllProducts();

        $transformed = null;
        foreach ($products as $product) {
            if ($product->getName() === $productName) {
                $transformed =  $this->productRepository->getProductById($product->getId());
            }
        }
        return $transformed;
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
        /** @var Total[] $cost */
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
