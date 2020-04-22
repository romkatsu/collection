<?php

declare(strict_types=1);

namespace Collection\Tests\Stub;

use Collection\InstanceCollection;

final class CustomerCollection extends InstanceCollection
{
    protected function getType(): string
    {
        return Customer::class;
    }

    public function offsetGet($key): ?Customer
    {
        return $this->getItem($key);
    }

    public function get($key): ?Customer
    {
        return $this->getItem($key);
    }

    public function first(callable $callback): ?Customer
    {
        return $this->findFirst($callback);
    }

    public function add(Customer $item, $key): void
    {
        $this->addItem($item, $key);
    }
}
