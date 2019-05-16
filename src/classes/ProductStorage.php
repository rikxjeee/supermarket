<?php


namespace Load\classes;

use Exception;

class ProductStorage
{
    /**
     * @var array
     */
    private $itemList;

    /**
     * ProductStorage constructor.
     */
    public function __construct()
    {
        $connection = new DataBase();
        $this->itemList = $connection->fetchAllProducts();
    }


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