<?php


namespace Load\classes;


use Exception;

class ProductStorage
{
    /**
     * @var array
     */
    private $itemList = [
        [
            'name' => 'Coca Cola',
            'type' => Product::TYPE_SOFT_DRINK,
            'price' => 0.8
        ],
        [
            'name' => 'Pepsi',
            'type' => Product::TYPE_SOFT_DRINK,
            'price' => 0.8
        ],
        [
            'name' => 'Goku Sandwich',
            'type' => Product::TYPE_SANDWICH,
            'price' => 2
        ],
        [
            'name' => 'Cubana',
            'type' => Product::TYPE_SANDWICH,
            'price' => 2
        ],
        [
            'name' => 'Fries',
            'type' => Product::TYPE_CRISP,
            'price' => 0.75
        ],
        [
            'name' => 'Soproni 1895',
            'type' => Product::TYPE_HARD_DRINK,
            'price' => 1
        ]
    ];

    /**
     * @param $productName
     * @return Product
     * @throws Exception
     */
    public function getByName($productName): Product
    {
        foreach ($this->itemList as $item) {
            if (strtolower($productName) == strtolower($item['name'])) {
                return new Product($item['name'], $item['price'], $item['type']);
            }
        }
        throw new Exception(sprintf('No such product: %s', $productName));
    }

    /**
     * @return Product[]
     */
    public function getAll(): array
    {
        $productList = [];
        foreach ($this->itemList as $item) {
            $productList[] = new Product($item['name'], $item['price'], $item['type']);
        }
        return $productList;
    }
}