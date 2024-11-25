<?php

declare(strict_types=1);

namespace App;

use App\Item\ItemInterface;

final class GildedRose
{
    public function updateQuality(ItemInterface $item): void
    {
        $item->updateQuality();
    }
}
