<?php

interface superMarketCart{
    const CRISPS_PRICE = 0.75;
    const DRINK_PRICE = 0.8;
    const SANDWICH_PRICE = 2;
    const MENU_PRICE = 3;
    const DOUBLE_CRISP_PRICE = 1;

    public function calculatePrice(array $param);
}







class cart implements superMarketCart{
    public function calculatePrice (array $param){
        echo $this->calculate($param);
    }

    private function calculate($ShopCart){
        $sum =0.0;
        $menus = min($ShopCart);
        foreach ($ShopCart as &$CartItems){
            $CartItems -= $menus;
        };

        unset($CartItems);

        if (($ShopCart["Crisps"] % 2) == 1){
            $sum+=self::CRISPS_PRICE;
            $ShopCart["Crisps"] -=1;
            $sum+= ($ShopCart["Crisps"]/2)*self::DOUBLE_CRISP_PRICE;
        }else{
            $sum+= ($ShopCart["Crisps"]/2)*self::DOUBLE_CRISP_PRICE;
        };

        if (date("l")=="Monday"){
            $sum+=$ShopCart["Drink"]*self::DRINK_PRICE/2;
        }else{
            $sum+=$ShopCart["Drink"]*self::DRINK_PRICE;
        }
        $sum += $ShopCart["Sandwich"]*self::SANDWICH_PRICE;
        $sum += $menus*self::MENU_PRICE;
        return $sum;

    }
}







class sortItems{

    private $ShoppingCart = [
        'Crisps' => 0,
        'Drink' => 0,
        'Sandwich' => 0,
    ];



    public function sort (array $params){
        foreach ($params as $items) {
            switch ($items) {
                case "Crisps":
                    $this->ShoppingCart["Crisps"]+=1;
                    break;
                case "Drink":
                    $this->ShoppingCart["Drink"]+=1;
                    break;
                case "Sandwich":
                    $this->ShoppingCart["Sandwich"]+=1;
                    break;
            };
        };
        return $this->ShoppingCart;
    }



    public function dump (array $param){
        var_dump($this->sort($param));
    }

    public function __toString()
    {
        return serialize($this->ShoppingCart);
    }
}

if ($argc > 1){
    $items = explode (",", $argv[1]);
}else{
    echo ("Wrong arguments!\n");
    exit (1);
}



$c = new sortItems();
$a = new cart();

$a->calculatePrice($c->sort($items));
echo "\n";
echo $c."\n";