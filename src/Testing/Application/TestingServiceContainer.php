<?php

namespace Supermarket\Testing\Application;

use Supermarket\Application\Calculator\CrispsDiscountCalculator;
use Supermarket\Application\Calculator\GrandTotalCalculator;
use Supermarket\Application\Calculator\SandwichMenuDiscountCalculator;
use Supermarket\Application\Calculator\SoftDrinkDiscountCalculator;
use Supermarket\Application\Calculator\SubTotalCalculator;
use Supermarket\Repository\CartRepository;
use Supermarket\Repository\ProductRepository;
use Supermarket\Testing\Repository\MemoryBasedCartRepository;
use Supermarket\Testing\Repository\MemoryBasedProductRepository;

class TestingServiceContainer
{
    public function getCartRepository(): CartRepository
    {
        return new MemoryBasedCartRepository($this->getProductRepository());
    }

    public function getProductRepository(): ProductRepository
    {
        return new MemoryBasedProductRepository();
    }

    public function getGrandTotalCalculator()
    {
        $calculators = [
            New SubTotalCalculator(),
            New SandwichMenuDiscountCalculator(),
            New SoftDrinkDiscountCalculator(),
            New CrispsDiscountCalculator()
        ];

        return new GrandTotalCalculator($calculators);
    }
}
