<?php

namespace App\Service\Calculator;

use App\Service\Sorter;

class CalculatorChain
{
    /** @var Calculator[] */
    private $calculators;

    /** @var Sorter */
    private $sorter;

    public function __construct(Sorter $sorter)
    {
        $this->calculators = [];
        $this->sorter = $sorter;
    }

    public function addCalculator(Calculator $calculator)
    {
        $this->calculators[] = $calculator;
    }

    /**
     * @return Calculator[]
     */
    public function getCalculators(): array
    {
        return $this->sorter->sort($this->calculators);
    }
}
