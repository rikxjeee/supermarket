<?php


namespace Load\classes;
use PDO;

class DataBase
{
    private $mySqlConnection;

    /**
     * DataBase constructor.
     */
    public function __construct()
    {
        $this->mySqlConnection = new PDO('mysql:host=localhost:9999;dbname=testing', 'root', 'simple');
    }

    public function fetchAllProducts()
    {
        $fetchProducts = $this->mySqlConnection->prepare('select * from products');
        $fetchProducts->execute();
        $productsArray = $fetchProducts->fetchAll(PDO::FETCH_ASSOC);
        return $productsArray;
    }
}