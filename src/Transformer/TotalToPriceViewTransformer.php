<?php

namespace Supermarket\Transformer;

use Supermarket\Model\Total;
use Supermarket\Model\View\Price\Price;
use Supermarket\Model\View\PriceListView;

class TotalToPriceViewTransformer
{
    /**
     * @param Total[] $totals
     *
     * @return PriceListView
     */
    public function transform(array $totals): PriceListView
    {
        $priceList = [];
        foreach ($totals as $total) {
            $priceList [] = new Price($total->getType(), $total->getSum());
        }

        return new PriceListView($priceList);
    }
}
