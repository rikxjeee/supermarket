<?php

namespace App\Tests\Behat\Provider;

use App\Service\Provider\Date\DateProvider;

class TestDateProvider implements DateProvider
{
    public function isToday(string $day): bool
    {
        return true;
    }
}
