<?php

namespace Supermarket\Transformer;

use Supermarket\Model\View\TotalListView;
use Supermarket\Model\View\TotalView\TotalView;

class TotalToTotalListViewTransformer
{
    /**
     * @param TotalListView[] $totals
     *
     * @return TotalListView
     */
    public function transform(array $totals): TotalListView
    {
        $priceList = [];
        foreach ($totals as $total) {
            $priceList [] = new TotalView($total->getType(), $total->getSum());
        }

        return new TotalListView($priceList);
    }
}
