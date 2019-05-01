<?php

namespace Load\classes;

use Exception;

class SortItems
{
    private $ShoppingCart = [
        'Crisps' => 0,
        'Drink' => 0,
        'Sandwich' => 0,
    ];

    public function sort($params)
    {
        foreach ($params as $items) {
            switch ($items) {
                case "Crisps":
                    $this->ShoppingCart["Crisps"] += 1;
                    break;
                case "Drink":
                    $this->ShoppingCart["Drink"] += 1;
                    break;
                case "Sandwich":
                    $this->ShoppingCart["Sandwich"] += 1;
                    break;
            };
        };
        return $this->ShoppingCart;
    }


    public function generateException()
    {
        try {
            throw new Exception('Something bad happened.');
        } catch (Exception $e) {
            echo "Test error: \n";
            echo "Error message: " . $e->getMessage()
                . "on line" . $e->getLine()
                . "in file " . $e->getFile() . ".\n"
                . "Error code: " . $e->getCode() . "\n";
        }
    }
    public function dump()
    {
        var_dump($this->ShoppingCart);
    }
}