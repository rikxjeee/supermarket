<?php

namespace Supermarket\Provider;

class UrlProvider
{
    public function getProductUrl(int $id): string
    {
        return sprintf('index.php?page=details&id=%d', $id);
    }
}
