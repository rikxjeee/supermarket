<?php

use App\Entity\Cart;
use App\Entity\Product;
use App\Entity\Total;
use App\Exception\ProductNotFoundException;
use App\Repository\CartRepository;
use App\Repository\ProductRepository;
use App\Service\Calculator\GrandTotalCalculator;
use App\Service\Provider\Date\DateProvider;
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

    /** @var DateProvider */
    private $dateProvider;

    public function __construct(
        CartRepository $cartRepository,
        ProductRepository $productRepository,
        GrandTotalCalculator $calculator,
        DateProvider $dateProvider
    ) {
        $this->cart = $cartRepository->getCart(null);
        $this->productRepository = $productRepository;
        $this->calculator = $calculator;
        $this->dateProvider = $dateProvider;
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
     * @throws Exception
     */
    public function iShouldHaveProductInMyRepository($quantity)
    {
        if ($quantity != count($this->productRepository->getAllProducts())) {
            throw new Exception ('Wrong number of product in the repository');
        }
    }

    /**
     * @Given It is Monday
     *
     * @throws Exception
     */
    public function itIsMonday()
    {
        $today = $this->dateProvider->isToday('Monday');
        if (!$today) {
            throw new Exception('It is not monday.');
        }
    }

    /**
     * @Given I have no items in my cart
     */
    public function iHaveNoItemsInMyCart()
    {
        if (!empty($this->cart->getItems())) {
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
     * @throws Exception
     */
    public function iShouldHaveItemsInMyCart($items)
    {
        $cartItems = 0;
        foreach ($this->cart->getItems() as $item) {
            $cartItems += $item->getQuantity();
        }
        if ($cartItems != $items) {
            throw new Exception(sprintf('I have %s item(s) in my cart.', $cartItems));
        }
    }

    /**
     * @Then The total cost of my cart will be :expectedCost
     *
     * @param $expectedCost
     *
     * @throws Exception
     */
    public function theTotalCostOfMyCartWillBe(float $expectedCost)
    {
        /** @var Total[] $cost */
        $cost = $this->calculator->getTotal($this->cart);
        $cost = $cost['Grand Total']->getSum();
        if (round($cost, 2) !== round($expectedCost, 2)) {
            throw new Exception(sprintf('Grand total should be "%s", not "%s"', $expectedCost, $cost));
        }
    }

    /**
     * @When I try add a non-existent item to my cart
     *
     * @throws Exception
     */
    public function iAddANonExistentItemToMyCart()
    {
        $exception = null;

        $nonExistentId = count($this->productRepository->getAllProducts()) + 1;
        try {
            $this->productRepository->getProductById($nonExistentId);
        } catch (ProductNotFoundException $e) {
            $exception = $e;
        }

        return $exception;
    }

    /**
     * @Then I should get Product not found error.
     *
     * @throws Exception
     */
    public function iShouldGetProductNotFoundError()
    {
        $error = $this->iAddANonExistentItemToMyCart();
        if (!$error) {
            throw new Exception('Test failed, product exists');
        }
    }
}
