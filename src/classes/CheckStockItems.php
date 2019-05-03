<?php


namespace Load\classes;


class CheckStockItems
{
    private $allowedItems;

    private $inStock;

    private $notInStock;

    public function __construct()
    {
        $this->allowedItems = new ItemPropertyProvider();

    }

    public function filterStockItems($userInput): array
    {
        foreach ($userInput as $value) {
            if (isset($this->allowedItems->itemList[$value])) {
                $this->inStock[] = $value;
            } else {
                $this->notInStock[$value] = $value;
            }
        }
        echo "\nWe don't have " . implode(", ", $this->notInStock) . ".\n";
        return $this->inStock;
    }
}