<?php

namespace Supermarket\Model\View;

use Supermarket\Model\View\Price\Price;

class PriceListView
{
    /** @var Price[] */
    private $priceList;

    /**
     * @param Price[] $priceList
     */
    public function __construct(array $priceList)
    {
        $this->priceList = $priceList;
    }

    /**
     * @return Price[]
     */
    public function getPriceList(): array
    {
        return $this->priceList;
    }
}
