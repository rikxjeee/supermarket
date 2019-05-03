<?php


namespace Load\classes;


class ItemPropertyProvider
{
    public $itemList;

    public function __construct()
    {
        $this->itemList = [
            'Drink' => 0.8,
            'Sandwich' => 2,
            'Crisps' => 0.75
        ];
    }
}