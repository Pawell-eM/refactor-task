<?php

declare(strict_types=1);

namespace App\Item;

abstract class LegendaryItem extends Item
{
    protected int $dailyQualityChange = 0;

    public function updateQuality(): void
    {
        # nothing will change in time
        return;
    }
}
