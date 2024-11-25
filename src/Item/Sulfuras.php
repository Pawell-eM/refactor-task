<?php

declare(strict_types=1);

namespace App\Item;

class Sulfuras extends LegendaryItem
{
    protected int $maxQuality = 80;

    function __construct(string $name, int $sellIn)
    {
        $this->name = $name;
        $this->sellIn = $sellIn;
        $this->quality = $this->maxQuality;
    }
}
