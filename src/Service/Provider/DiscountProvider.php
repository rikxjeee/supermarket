<?php

namespace App\Service\Provider;

use App\Entity\Product;
use App\Service\Provider\Date\DateProvider;

class DiscountProvider
{
    const MENU_ITEMS = [Product::TYPE_SANDWICH, Product::TYPE_SOFT_DRINK, Product::TYPE_CRISP];

    /** @var DateProvider */
    private $dateProvider;

    public function __construct(DateProvider $dateProvider)
    {
        $this->dateProvider = $dateProvider;
    }

    public function isSoftDrinkDiscountApplies(): bool
    {
        return $this->dateProvider->isToday('Monday');
    }

    public function getMenuItems(): array
    {
        return self::MENU_ITEMS;
    }

    public function getMenuPrice(): int
    {
        return 3;
    }
}
