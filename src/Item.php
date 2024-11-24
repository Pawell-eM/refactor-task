<?php

declare(strict_types=1);

namespace App;

interface ItemInterface
{
    public function updateQuality(): void;
}

class Item implements ItemInterface
{
    const DAILY_QUALITY_CHANGE = -1;

    public string $name;
    public int $sell_in;
    public int $quality;

    protected DateTime $lastUpdatedTime;

    function __construct(string $name, int $sell_in, int $quality)
    {
        $this->name = $name;
        $this->sell_in = $sell_in;
        $this->quality = $quality;

        $this->qualityAssurance();
    }

    public function __toString(): string
    {
        return "{$this->name}, {$this->sell_in}, {$this->quality}";
    }

    public function updateQuality(): void
    {
        $now = new DateTime();
        if ($this->wasUpdatedToday($now)) {
            return;
        }

        $this->sell_in--;
        if (self::DAILY_QUALITY_CHANGE !== 0) {
            $quality_change_factor = ($this->sell_in < 0) ? 2 : 1;
            $this->quality += self::DAILY_QUALITY_CHANGE * $quality_change_factor;
            $this->qualityAssurance();
        }
        $this->lastUpdatedTime = $now;
    }

    protected function wasUpdatedToday(DateTime $now): bool
    {
        return $this->lastUpdatedTime !== null && $now->format('Ymd') === $this->lastUpdatedTime->format('Ymd');
    }

    protected function qualityAssurance(): void
    {
        if ($this->quality < 0) {
            $this->quality = 0;
        }
        elseif ($this->quality > 50) {
            $this->quality = 50;
        }
    }
}

class AgedBrie extends Item
{
    const DAILY_QUALITY_CHANGE = 1;
}

class BackstagePass extends Item
{
    const DAILY_QUALITY_CHANGE = 0; # different logic applied below

    public function updateQuality(): void
    {
        $now = new DateTime();
        if ($this->wasUpdatedToday($now)) {
            return;
        }

        $this->sell_in--;

        if ($this->sell_in <= 10) {
            $quality_change_factor = 2;
            if ($this->sell_in <= 5) {
                $quality_change_factor = 3;
            }
            elseif ($this->sell_in < 0) {
                $quality_change_factor = 0;
            }

            $this->quality += $this->qualityDailyChange * $quality_change_factor;
            $this->qualityAssurance();
        }

        $this->lastUpdatedTime = $now;
    }
}

abstract class LegendaryItem extends Item
{
    const DAILY_QUALITY_CHANGE = 0;

    public function updateQuality(): void
    {
        return;
    }
}

class Sulfuras extends LegendaryItem
{
    function __construct($name)
    {
        $this->name = $name;
        $this->sell_in = 0;
        $this->quality = 80;
    }
}
