<?php

namespace Load\classes;

use Exception;

class SortItems
{
    public function generateException()
    {
        try {
            throw new Exception('Something bad happened.');
        } catch (Exception $e) {
            echo "Test error: \n";
            echo "Error message: '" . $e->getMessage() . "' "
                . "on line " . $e->getLine()
                . " in file " . $e->getFile() . ".\n"
                . "Error code: " . $e->getCode() . "\n";
        }
    }

    public function dump()
    {
        var_dump($this->ShoppingCart);
    }
}