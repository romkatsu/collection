<?php

declare(strict_types=1);

namespace Collection;

use InvalidArgumentException;

abstract class InstanceCollection extends TypeCollection
{
    abstract protected function getType(): string;

    protected function checkType($item): void
    {
        $type = $this->getType();

        if (!($item instanceof $type)) {
            throw new InvalidArgumentException("Item can contain only $type type.");
        }
    }
}
