<?php

declare(strict_types=1);

namespace Collection;

use ArrayIterator;
use Closure;
use Countable;
use IteratorAggregate;
use ArrayAccess;

use function array_keys;
use function array_values;
use function count;

abstract class TypeCollection implements IteratorAggregate, Countable, ArrayAccess
{
    protected array $items = [];

    public function __construct(array $items = [])
    {
        foreach ($items as $item) {
            $this->checkType($item);
        }

        $this->items = $items;
    }

    abstract protected function checkType($item): void;

    abstract public function offsetGet($key);

    public function toArray(): array
    {
        return $this->items;
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->items);
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function has($key): bool
    {
        return isset($this->items[$key]);
    }

    public function remove($key): void
    {
        if (isset($this->items[$key])) {
            unset($this->items[$key]);
        }
    }

    public function clear(): void
    {
        $this->items = [];
    }

    public function exists(Closure $p): bool
    {
        foreach ($this->items as $key => $item) {
            if ($p($item, $key)) {
                return true;
            }
        }

        return false;
    }

    public function getKeys(): array
    {
        return array_keys($this->items);
    }

    public function getValues(): array
    {
        return array_values($this->items);
    }

    public function isEmpty(): bool
    {
        return empty($this->items);
    }

    public static function fromArray(array $array): self
    {
        return new static($array);
    }

    public function offsetExists($key): bool
    {
        return $this->has($key);
    }

    public function offsetSet($key, $item): void
    {
        $this->addItem($item, $key);
    }

    public function offsetUnset($key): void
    {
        $this->remove($key);
    }

    public function filter(callable $callable): self
    {
        return new static(\array_filter($this->items, $callable, ARRAY_FILTER_USE_BOTH));
    }

    public function map(callable $callback): array
    {
        return array_map($callback, $this->items);
    }

    protected function getItem($key)
    {
        return $this->items[$key] ?? null;
    }

    protected function findFirst(callable $callback)
    {
        foreach ($this->items as $item) {
            if ($callback($item) === true) {
                return $item;
            }
        }
        return null;
    }

    protected function addItem($item, $key): void
    {
        $this->checkType($item);

        $this->items[$key] = $item;
    }
}
