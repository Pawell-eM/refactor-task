<?php

declare(strict_types=1);

use App\GildedRose;
use PHPUnit\Framework\TestCase;

class GildedRoseTest extends TestCase
{
    /**
     * @dataProvider itemsProvider
     */
    public function testUpdateQualityTest(string $className, string $name, int $sellIn, int $quality, int $expectedSellIn, int $expectedQuality): void
    {
        $className = 'App\\' . $className;
        $item = new $className($name, $sellIn, $quality);

        $gildedRose = new GildedRose();
        $gildedRose->updateQuality($item);

        $this->assertEquals($expectedSellIn, $item->getSellIn());
        $this->assertEquals($expectedQuality, $item->getQuality());
    }

    public function itemsProvider(): array
    {
        return [
            'Aged Brie before sell in date' => ['AgedBrie', 'Aged Brie', 10, 10, 9, 11],
            'Aged Brie sell in date' => ['AgedBrie', 'Aged Brie', 0, 10, -1, 12],
            'Aged Brie after sell in date' => ['AgedBrie', 'Aged Brie', -5, 10, -6, 12],
            'Aged Brie before sell in date with maximum quality' => ['AgedBrie', 'Aged Brie', 5, 50, 4, 50],
            'Aged Brie sell in date near maximum quality' => ['AgedBrie', 'Aged Brie', 0, 49, -1, 50],
            'Aged Brie sell in date with maximum quality' => ['AgedBrie', 'Aged Brie', 0, 50, -1, 50],
            'Aged Brie after_sell in date with maximum quality' => ['AgedBrie', 'Aged Brie', -10, 50, -11, 50],
            'Backstage passes before sell in date' => ['BackstagePasses', 'Backstage passes to a TAFKAL80ETC concert', 10, 10, 9, 12],
            'Backstage passes more than 10 days before sell in date' => ['BackstagePasses', 'Backstage passes to a TAFKAL80ETC concert', 11, 10, 10, 11],
            'Backstage passes five days before sell in date' => ['BackstagePasses', 'Backstage passes to a TAFKAL80ETC concert', 5, 10, 4, 13],
            'Backstage passes sell in date' => ['BackstagePasses', 'Backstage passes to a TAFKAL80ETC concert', 0, 10, -1, 0],
            'Backstage passes close to sell in date with maximum quality' => ['BackstagePasses', 'Backstage passes to a TAFKAL80ETC concert', 10, 50, 9, 50],
            'Backstage passes very close to sell in date with maximum quality' => ['BackstagePasses', 'Backstage passes to a TAFKAL80ETC concert', 5, 50, 4, 50],
            'Backstage passes after sell in date' => ['BackstagePasses', 'Backstage passes to a TAFKAL80ETC concert', -5, 50, -6, 0],
            'Sulfuras before sell in date' => ['Sulfuras', 'Sulfuras, Hand of Ragnaros', 10, 80, 10, 80],
            'Sulfuras sell in date' => ['Sulfuras', 'Sulfuras, Hand of Ragnaros', 0, 80, 0, 80],
            'Sulfuras after sell in date' => ['Sulfuras', 'Sulfuras, Hand of Ragnaros', -1, 80, -1, 80],
            'Elixir of the Mongoose before sell in date' => ['Item', 'Elixir of the Mongoose', 10, 10, 9, 9],
            'Elixir of the Mongoose sell in date' => ['Item', 'Elixir of the Mongoose', 0, 10, -1, 8],
            'Elixir of the Mongoose after sell in date with one quality' => ['Item', 'Elixir of the Mongoose', -1, 1, -2, 0],
            'Elixir of the Mongoose after sell in date with zero quality' => ['Item', 'Elixir of the Mongoose', -2, 0, -3, 0],
        ];
    }
}
