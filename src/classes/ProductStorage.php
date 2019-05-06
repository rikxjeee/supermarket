<?php


namespace Load\classes;


use Exception;

class ProductStorage
{
    private $itemList;

    public function __construct()
    {
        $this->itemList = [
            'Drink' => 0.8,
            'Sandwich' => 2,
            'Crisps' => 0.75,
            'Beer' => 1
        ];
    }

    /**
     * @param $productName
     * @return Product
     * @throws Exception
     */
    public function getByName($productName): Product
    {
        if (!isset($this->itemList[$productName])){
            throw new Exception("Product not found.");
        }
        return new Product($productName, $this->itemList[$productName]);
    }
}