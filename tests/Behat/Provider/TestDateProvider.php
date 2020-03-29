<?php

namespace App\Tests\Behat\Provider;

use App\Service\Provider\Date\DateProvider;

class TestDateProvider implements DateProvider
{
    private $currentDay;
    
    public function isToday(string $day): bool
    {
        return $day === $this->currentDay;
    }

    public function setCurrentDay($day)
    {
        $this->currentDay = $day;
    }
}
