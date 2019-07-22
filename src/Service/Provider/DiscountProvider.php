<?php

namespace App\Service\Provider;

use App\Entity\Product;

class DiscountProvider
{
    const MENU_ITEMS = [Product::TYPE_SANDWICH, Product::TYPE_SOFT_DRINK, Product::TYPE_CRISP];

    public function isSoftDrinkDiscountApplies(): bool
    {
        return date('l') === 'Monday';
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
