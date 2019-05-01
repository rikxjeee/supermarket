<?php

require 'vendor/autoload.php';

if ($argc > 1) {
    $items = explode(",", $argv[1]);
} else {
    echo("Wrong arguments!");
    exit (1);
}


$a = new Load\classes\SortItems();
$b = new Load\classes\Cart();

echo $b->calculatePrice($a->sort($items)) . "\n";