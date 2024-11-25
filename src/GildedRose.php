<?php

declare(strict_types=1);

namespace App;

final class GildedRose
{
    public function updateQuality(ItemInterface $item): void
    {
        $item->updateQuality();
    }
}
