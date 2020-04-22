<?php

declare(strict_types=1);

namespace Collection\Tests;

use PHPUnit\Framework\TestCase;
use Collection\IntegerCollection;
use InvalidArgumentException;

final class IntegerCollectionTest extends TestCase
{
    /**
     * @test
     */
    public function createByInvalidItems(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new IntegerCollection([1, 2, '3']);
    }

    /**
     * @test
     */
    public function createByValidItems(): void
    {
        try {
            new IntegerCollection([1, 2, 3]);
        } catch (InvalidArgumentException $e) {
            $this->fail();
        }

        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function addValidItem(): void
    {
        $collection = new IntegerCollection([1, 2, 3]);
        $collection->add(4, 4);
        $this->assertCount(4, $collection);
    }

    /**
     * @test
     */
    public function removeItem(): void
    {
        $collection = new IntegerCollection([1, 2, 3]);
        $collection->remove(0);
        $this->assertCount(2, $collection);
    }


    /**
     * @test
     */
    public function getItem(): void
    {
        $collection = new IntegerCollection([1, 2, 3]);
        $this->assertEquals(3, $collection->get(2));
    }


    /**
     * @test
     */
    public function getFirstItem(): void
    {
        $collection = new IntegerCollection([101, 102, 1033]);
        $this->assertEquals(101, $collection->first());
    }

    /**
     * @test
     */
    public function filterItems(): void
    {
        $collection = new IntegerCollection([101, 102, 1033]);

        $this->assertEquals(
            [101, 102],
            $collection->filter(
                static function (int $item) {
                    return $item < 1000;
                }
            )->toArray()
        );
    }

    /**
     * @test
     */
    public function toArrayItems(): void
    {
        $items = [101, 102, 1033];
        $collection = new IntegerCollection($items);
        $this->assertEquals($items, $collection->toArray());
    }

    /**
     * @test
     */
    public function mapItems(): void
    {
        $items = [101, 102, 1033];
        $collection = new IntegerCollection($items);
        $this->assertEquals(
            [
                0 => [
                    'VALUE' => 101,
                ],
                1 => [
                    'VALUE' => 102,
                ],
                2 => [
                    'VALUE' => 1033,
                ]
            ],
            $collection->map(
                static function (int $item) {
                    return [
                        'VALUE' => (string)$item
                    ];
                }
            )
        );
    }
}
