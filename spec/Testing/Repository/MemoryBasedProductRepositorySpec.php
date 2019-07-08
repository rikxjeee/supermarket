<?php

namespace spec\Supermarket\Testing\Repository;

use PhpSpec\ObjectBehavior;
use Supermarket\Model\Product;
use Supermarket\Repository\ProductRepository;
use Supermarket\Testing\Repository\MemoryBasedProductRepository;

class MemoryBasedProductRepositorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(MemoryBasedProductRepository::class);
        $this->shouldBeAnInstanceOf(ProductRepository::class);
    }

    function it_can_return_all_products()
    {
        $this->addProduct(new Product(1, 'coke', 1, Product::TYPE_SOFT_DRINK));
        $this->addProduct(new Product(1, 'coke', 1, Product::TYPE_SOFT_DRINK));
        $this->addProduct(new Product(1, 'coke', 1, Product::TYPE_SOFT_DRINK));

        $products = $this->getAllProducts();
        $products->shouldBeArray();
        $products->shouldContainOnly(Product::class);
    }

    function it_can_return_a_single_product()
    {
        $this->addProduct(new Product(1, 'coke', 1, Product::TYPE_SOFT_DRINK));
        $this->addProduct(new Product(1, 'coke', 1, Product::TYPE_SOFT_DRINK));
        $this->addProduct(new Product(1, 'coke', 1, Product::TYPE_SOFT_DRINK));

        $this->getProductById(1)->shouldReturnAnInstanceOf(Product::class);
        $this->getProductById(1)->getName()->shouldReturn('coke');
    }

    function it_can_add_more_product()
    {
        $product = new Product(1, 'coke', 1, Product::TYPE_SOFT_DRINK);
        $count = count($this->getWrappedObject()->getAllProducts());
        $this->addProduct($product);
        $this->getAllProducts()->shouldHaveCount($count + 1);
    }

    function getMatchers(): array
    {
        return [
            'containOnly' => function ($subject, $class) {
                foreach ($subject as $product) {
                    if (get_class($product) !== $class) {
                        return false;
                    }
                }

                return true;
            }
        ];
    }
}
