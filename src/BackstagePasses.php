<?php

declare(strict_types=1);

namespace App;

use DateTime;

class BackstagePasses extends Item
{
    protected int $dailyQualityChange = 1;

    protected function calculateQualityValue(): int
    {
        if ($this->sellIn < 0) {
            return 0;
        }

        return $this->quality + $this->dailyQualityChange * $this->getQualityChangeFactor();
    }

    protected function getQualityChangeFactor(): int
    {
        $qualityChangeFactor = 1;
        if ($this->sellIn < 5) {
            $qualityChangeFactor = 3;
        }
        elseif ($this->sellIn < 10) {
            $qualityChangeFactor = 2;
        }

        return $qualityChangeFactor;
    }
}
