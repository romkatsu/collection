<?php

declare(strict_types=1);

namespace Collection;

use InvalidArgumentException;

class StringCollection extends TypeCollection
{
    protected function checkType($item): void
    {
        if (!is_string($item)) {
            throw new InvalidArgumentException('Item can contain only string type.');
        }
    }

    public function offsetGet($key): ?string
    {
        return $this->getItem($key);
    }

    public function get($key): ?string
    {
        return $this->getItem($key);
    }

    public function first(): ?string
    {
        return array_shift($this->items);
    }

    public function add(string $item, $key): void
    {
        $this->addItem($item, $key);
    }
}
