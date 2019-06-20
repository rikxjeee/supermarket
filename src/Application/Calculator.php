<?php

namespace Supermarket\Application;

use Supermarket\Model\Cart;
use Supermarket\Model\Total;

interface Calculator
{
    public function getTotal(Cart $cart): Total;
}
