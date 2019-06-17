<?php

namespace Supermarket\Provider;

class UrlProvider
{
    public function getProductUrl(int $id): string
    {
        return sprintf('index.php?page=details&id=%d', $id);
    }

    public function getProductListUrl(): string
    {
        return 'index.php?page=products';
    }

    public function getCartUrl(): string
    {
        return 'index.php?page=cart';
    }
}
