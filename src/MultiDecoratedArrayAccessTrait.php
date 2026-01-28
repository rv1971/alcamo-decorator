<?php

namespace alcamo\decorator;

use alcamo\exception\ReadonlyViolation;

/**
 * @brief alcamo::decorator::MultiDecoratedTrait plus readonly array access to
 * the decorators
 *
 * @date Last reviewed 2026-01-28
 */
trait MultiDecoratedArrayAccessTrait
{
    use MultiDecoratedTrait;

    public function offsetExists($offset): bool
    {
        return $this->getDecorator($offset) !== null;
    }

    public function offsetGet($offset)
    {
        return $this->getDecorator($offset);
    }

    public function offsetSet($offset, $value): void
    {
        /** @throw alcamo::exception::ReadonlyViolation in every
         *  invocation. */
        throw new ReadonlyViolation();
    }

    public function offsetUnset($offset): void
    {
        /** @throw alcamo::exception::ReadonlyViolation in every
         *  invocation. */
        throw new ReadonlyViolation();
    }
}
