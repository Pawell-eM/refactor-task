<?php

declare(strict_types=1);

namespace App\Item;

use DateTime;

class Item implements ItemInterface
{
    protected int $dailyQualityChange = -1;
    protected int $maxQuality = 50;

    protected string $name;
    protected int $sellIn;
    protected int $quality;
    protected ?DateTime $lastUpdatedTime = null; # better if quality will be updated after midnigth, to not bother about date change that can occur

    function __construct(string $name, int $sellIn, int $quality)
    {
        $this->name = $name;
        $this->sellIn = $sellIn;
        $this->quality = $quality;

        $this->qualityAssurance();
    }

    public function __toString(): string
    {
        return "{$this->name}, {$this->sellIn}, {$this->quality}";
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getQuality(): int
    {
        return $this->quality;
    }

    public function getSellIn(): int
    {
        return $this->sellIn;
    }

    public function updateQuality(): void
    {
        $now = new DateTime();
        if ($this->wasUpdatedToday($now)) {
            return;
        }

        $this->sellIn--;
        if ($this->dailyQualityChange !== 0) {
            $this->quality = $this->calculateQualityValue();
            $this->qualityAssurance();
        }

        $this->setLastUpdated($now);
    }

    protected function calculateQualityValue(): int
    {
        return $this->quality + $this->dailyQualityChange * $this->getQualityChangeFactor();
    }

    protected function getQualityChangeFactor(): int
    {
        return ($this->sellIn < 0) ? 2 : 1;
    }

    protected function wasUpdatedToday(DateTime $today): bool
    {
        return $this->lastUpdatedTime !== null && $today->format('Ymd') === $this->lastUpdatedTime->format('Ymd');
    }

    protected function setLastUpdated(DateTime $time): void
    {
        $this->lastUpdatedTime = $time;
    }

    protected function qualityAssurance(): void
    {
        if ($this->quality < 0) {
            $this->quality = 0;
        }
        elseif ($this->quality > $this->maxQuality) {
            $this->quality = $this->maxQuality;
        }
    }
}
