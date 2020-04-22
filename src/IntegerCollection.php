<?php

declare(strict_types=1);

namespace Collection;

use InvalidArgumentException;

class IntegerCollection extends TypeCollection
{
    protected function checkType($item): void
    {
        if (!is_int($item)) {
            throw new InvalidArgumentException('Item can contain only int type.');
        }
    }

    public function offsetGet($key): ?int
    {
        return $this->getItem($key);
    }

    public function get($key): ?int
    {
        return $this->getItem($key);
    }

    public function first(): ?int
    {
        return array_shift($this->items);
    }

    public function add(int $item, $key): void
    {
        $this->addItem($item, $key);
    }
}
