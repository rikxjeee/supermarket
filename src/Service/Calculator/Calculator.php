<?php

namespace App\Service\Calculator;

use App\Entity\CartItem;
use App\Entity\Total;

interface Calculator
{
    /**
     * @param CartItem[] $item
     *
     * @return Total
     */
    public function getTotal(array $item): Total;

    public function getType(): string;
}
