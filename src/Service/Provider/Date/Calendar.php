<?php

namespace App\Service\Provider\Date;

class Calendar implements DateProvider
{
    public function isToday(string $day): bool
    {
        return true;// $day === date('l');
    }
}
