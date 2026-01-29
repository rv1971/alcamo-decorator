<?php

namespace alcamo\decorator;

/**
 * @brief Decorator that delegates __toString() to the handler
 *
 * The __toString() method is written down explicitely because otherwise
 * PHP would not recognize that it is implemented, even though the
 * implementation is equivalent to the implicit use of the magic methods.
 *
 * @date Last reviewed 2026-01-29
 */
trait StringableDecoratorTrait
{
    public function __toString(): string
    {
        return (string)$this->handler_;
    }
}
