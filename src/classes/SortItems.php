<?php

namespace Load\classes;

class SortItems
{

    private $ShoppingCart = [
        'Crisps' => 0,
        'Drink' => 0,
        'Sandwich' => 0,
    ];


    public function sort(array $params)
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


    public function dump(array $param)
    {
        var_dump($this->sort($param));
    }

    public function __toString()
    {
        return json_encode($this->ShoppingCart);
    }
}