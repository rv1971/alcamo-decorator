<?php

namespace alcamo\decorator;

/**
 * @brief Decorator that delegates count() to the handler
 *
 * The __toString() method is written down explicitely because otherwise
 * PHP would not recognize that it is implemented, even though the
 * implementation is equivalent to the implicit use of the magic methods.
 *
 * @date Last reviewed 2026-01-29
 */
trait CountableDecoratorTrait
{
    public function count(): int
    {
        return $this->handler_->count();
    }
}
