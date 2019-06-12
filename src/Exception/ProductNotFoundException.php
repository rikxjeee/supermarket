<?php

namespace Supermarket\Exception;

use Exception;

class ProductNotFoundException extends Exception
{
    public static function createFromId(int $id): ProductNotFoundException
    {
        return new self(sprintf('Product with id "%d" does not exists.', $id));
    }
}
