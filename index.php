<?php
/*
 * procedural version
 */
const CRISPS_PRICE = 0.75;
const DRINK_PRICE = 0.8;
const SANDWICH_PRICE = 2;
const MENU_PRICE = 3;
const DOUBLE_CRISP_PRICE = 1;

$ShoppingCart = [
    "Crisps" => 0,
    "Drink" => 0,
    "Sandwich" => 0,
];

function calculatePrice($ShopCart){
    $sum =0.0;
    $menus= min($ShopCart);
    foreach ($ShopCart as &$CartItems){
        $CartItems -=$menus;
    };

    unset($CartItems);

    if (($ShopCart["Crisps"] % 2) ==1){
        $sum+=CRISPS_PRICE;
        $ShopCart["Crisps"] -=1;
        $sum+= ($ShopCart["Crisps"]/2)*DOUBLE_CRISP_PRICE;
    }else{
        $sum+= ($ShopCart["Crisps"]/2)*DOUBLE_CRISP_PRICE;
    };

    if (date("l")=="Monday"){
        $sum+=$ShopCart["Drink"]*DRINK_PRICE/2;
    }else{
        $sum+=$ShopCart["Drink"]*DRINK_PRICE;
    }
    $sum+=$menus*MENU_PRICE;
    $sum += $ShopCart["Sandwich"]*SANDWICH_PRICE;

    return $sum;

}

if ($argc > 1){
    $items = explode (",", $argv[1]);
}else{
    echo ("Wrong arguments!\n");
    exit (1);
}

foreach ($items as $cucc) {
    switch ($cucc) {
        case "Crisps":
            $ShoppingCart["Crisps"]+=1;
            break;
        case "Drink":
            $ShoppingCart["Drink"]+=1;
            break;
        case "Sandwich":
            $ShoppingCart["Sandwich"]+=1;
            break;
    };
};
echo(calculatePrice($ShoppingCart))."\n";

