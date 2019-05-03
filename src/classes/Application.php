<?php

namespace Load\classes;

class Application
{
    private $userInput;
    private $checkStockItems;

    public function __construct(array $argv, int $argc)
    {
        $this->userInput = new UserInput($argv, $argc);
        $this->checkStockItems = new CheckStockItems();

    }

    public function runApplication()
    {
        $myCart = new Cart;

        $myCart->addItems($this->checkStockItems->filterStockItems($this->userInput->getUserInput()));

        echo $myCart;

        echo "£" . $myCart->getPrice() . "\n";
    }
}