<?php

namespace Supermarket\Model\View;

use Supermarket\Model\View\TotalView\TotalView;

class TotalListView
{
    /** @var TotalView[] */
    private $priceList;

    /**
     * @param TotalView[] $priceList
     */
    public function __construct(array $priceList)
    {
        $this->priceList = $priceList;
    }

    /**
     * @return TotalView[]
     */
    public function getPriceList(): array
    {
        return $this->priceList;
    }
}
