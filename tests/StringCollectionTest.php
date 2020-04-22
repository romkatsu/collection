<?php

declare(strict_types=1);

namespace Collection\Tests;

use PHPUnit\Framework\TestCase;
use InvalidArgumentException;
use Collection\StringCollection;

final class StringCollectionTest extends TestCase
{
    /**
     * @test
     */
    public function createByInvalidItems(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new StringCollection(['one', 'two', 3]);
    }

    /**
     * @test
     */
    public function createByValidItems(): void
    {
        try {
            new StringCollection(['one', 'two', 'three']);
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
        $collection = new StringCollection(['one', 'two', 'three']);
        $collection->add('four', 3);
        $this->assertCount(4, $collection);
    }

    /**
     * @test
     */
    public function removeItem(): void
    {
        $collection = new StringCollection(['one', 'two', 'three']);
        $collection->remove(0);
        $this->assertCount(2, $collection);
    }


    /**
     * @test
     */
    public function getItem(): void
    {
        $collection = new StringCollection(['one', 'two', 'three']);
        $this->assertEquals('three', $collection->get(2));
    }

    /**
     * @test
     */
    public function getFirstItem(): void
    {
        $collection = new StringCollection(['one', 'two', 'three']);
        $this->assertEquals('one', $collection->first());
    }

    /**
     * @test
     */
    public function filterItems(): void
    {
        $collection = new StringCollection(['one', 'two', 'three']);

        $this->assertEquals(
            [2 => 'three'],
            $collection->filter(
                static function (string $item) {
                    return strlen($item) > 3;
                }
            )->toArray()
        );
    }

    /**
     * @test
     */
    public function toArrayItems(): void
    {
        $items = ['one', 'two', 'three'];
        $collection = new StringCollection($items);
        $this->assertEquals($items, $collection->toArray());
    }

    /**
     * @test
     */
    public function mapItems(): void
    {
        $items = ['one', 'two', 'three'];
        $collection = new StringCollection($items);
        $this->assertEquals(
            [
                0 => [
                    'VALUE' => 'one',
                ],
                1 => [
                    'VALUE' => 'two',
                ],
                2 => [
                    'VALUE' => 'three',
                ]
            ],
            $collection->map(
                static function (string $item) {
                    return [
                        'VALUE' => $item
                    ];
                }
            )
        );
    }
}
