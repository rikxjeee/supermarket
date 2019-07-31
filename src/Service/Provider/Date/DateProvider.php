<?php

namespace App\Service\Provider\Date;

interface DateProvider
{
    public function isToday(string $day): bool;
}
