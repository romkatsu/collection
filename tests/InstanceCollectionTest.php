<?php

declare(strict_types=1);

namespace Collection\Tests;

use PHPUnit\Framework\TestCase;
use Collection\Tests\Stub\Customer;
use Collection\Tests\Stub\CustomerCollection;
use InvalidArgumentException;

final class InstanceCollectionTest extends TestCase
{
    /**
     * @test
     */
    public function createByInvalidItems(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $items = [
            new Customer(1, 'first'),
            new Customer(1, 'two'),
            new \stdClass()
        ];

        new CustomerCollection($items);
    }

    /**
     * @test
     */
    public function createByValidItems(): void
    {
        $items = [
            new Customer(1, 'first'),
            new Customer(2, 'tow'),
            new Customer(3, 'three'),
        ];

        try {
            new CustomerCollection($items);
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
        $items = [
            1 => new Customer(1, 'first'),
            2 => new Customer(2, 'tow'),
            3 => new Customer(3, 'three'),
        ];

        $collection = new CustomerCollection($items);
        $newCustomer = new Customer(4, 'four');

        $collection->add($newCustomer, 4);
        $this->assertCount(4, $collection);
    }

    /**
     * @test
     */
    public function removeItem(): void
    {
        $items = [
            1 => new Customer(1, 'first'),
            2 => new Customer(2, 'tow'),
            3 => new Customer(3, 'three'),
        ];

        $collection = new CustomerCollection($items);
        $collection->remove(3);
        $this->assertCount(2, $collection);
    }


    /**
     * @test
     */
    public function getItem(): void
    {
        $firstCustomer = new Customer(1, 'first');
        $twoCustomer = new Customer(2, 'two');

        $items = [
            1 => $firstCustomer,
            2 => $twoCustomer,
        ];

        $collection = new CustomerCollection($items);
        $this->assertEquals($twoCustomer, $collection->get(2));
    }


    /**
     * @test
     */
    public function getFirstItem(): void
    {
        $firstCustomer = new Customer(1, 'first');
        $twoCustomer = new Customer(2, 'two');

        $items = [
            1 => $firstCustomer,
            2 => $twoCustomer,
        ];

        $collection = new CustomerCollection($items);

        $this->assertEquals(
            $firstCustomer,
            $collection->first(
                static function (Customer $item) {
                    return $item->getName() === 'first';
                }
            )
        );
    }

    /**
     * @test
     */
    public function filterItems(): void
    {
        $firstCustomer = new Customer(1, 'first');
        $twoCustomer = new Customer(2, 'two');
        $threeCustomer = new Customer(3, 'three');

        $items = [
            1 => $firstCustomer,
            2 => $twoCustomer,
            3 => $threeCustomer
        ];

        $collection = new CustomerCollection($items);

        $this->assertEquals(
            [
                2 => $twoCustomer,
                3 => $threeCustomer
            ],
            $collection->filter(
                static function (Customer $item) {
                    return $item->getId() > 1;
                }
            )->toArray()
        );
    }

    /**
     * @test
     */
    public function toArrayItems(): void
    {
        $items = [
            1 => new Customer(1, 'first'),
            2 => new Customer(2, 'tow'),
            3 => new Customer(3, 'three'),
        ];

        $collection = new CustomerCollection($items);
        $this->assertEquals($items, $collection->toArray());
    }

    /**
     * @test
     */
    public function mapItems(): void
    {
        $items = [
            1 => new Customer(1, 'first'),
            2 => new Customer(2, 'two'),
        ];

        $collection = new CustomerCollection($items);
        $this->assertEquals(
            [
                1 => [
                    'ID' => 1,
                    'NAME' => 'first'
                ],
                2 => [
                    'ID' => 2,
                    'NAME' => 'two'
                ]
            ],
            $collection->map(
                static function (Customer $item) {
                    return [
                        'ID' => $item->getId(),
                        'NAME' => $item->getName()
                    ];
                }
            )
        );
    }
}
