<?php

namespace alcamo\decorator;

/**
 * @brief Decorator that delegates the ArrayAccess methods to the handler
 *
 * The needed methods are written down explicitely because otherwise PHP would
 * not recognize that they are implemented, even though their implementation
 * is equivalent to the implicit use of the magic methods.
 *
 * @date Last reviewed 2026-01-29
 */
trait ArrayAccessDecoratorTrait
{
    public function offsetExists($offset): bool
    {
        return $this->handler_->offsetExists($offset);
    }

    public function offsetGet($offset)
    {
        return $this->handler_->offsetGet($offset);
    }

    public function offsetSet($offset, $value): void
    {
        $this->handler_->offsetSet($offset, $value);
    }

    public function offsetUnset($offset): void
    {
        $this->handler_->offsetUnset($offset);
    }
}
