<?php

namespace App\Service;

use App\Service\Calculator\Calculator;

class Sorter
{
    private const CALCULATOR_PRIORITY = ['SubTotal', 'SandwichMenu', 'Crisps', 'SoftDrink'];

    /**
     * @param Calculator[] $calculators
     *
     * @return Calculator[]
     */
    public function sort(array $calculators): array
    {
        $sorted = [];

        foreach (self::CALCULATOR_PRIORITY as $type) {
            foreach ($calculators as $calculator) {
                if ($type === $calculator->getType()) {
                    $sorted[$type] = $calculator;
                }
            }
        }

        return $sorted;
    }
}
