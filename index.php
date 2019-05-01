<?php

require 'vendor/autoload.php';

if ($argc > 1) {
    $items = explode(",", $argv[1]);
} else {
    echo ("Wrong arguments!") . "\n";
    exit (1);
}


$a = new Load\classes\SortItems();
$b = $a->sort($items);
$myCart = new Load\classes\Cart($b);

$a->generateException();

echo "Your cart: \n" . $myCart . "\n";

echo "£" . $myCart->calculatePrice() . "\n";