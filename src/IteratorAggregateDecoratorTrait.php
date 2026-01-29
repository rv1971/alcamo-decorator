<?php

namespace alcamo\decorator;

/**
 * @brief Decorator that delegates getIterator() to the handler
 *
 * The getIterator method is written down explicitely because otherwise
 * PHP would not recognize that it is implemented, even though the
 * implementation is equivalent to the implicit use of the magic methods.
 *
 * @date Last reviewed 2026-01-29
 */
trait IteratorAggregateDecoratorTrait
{
    public function getIterator()
    {
        return $this->handler_->getIterator();
    }
}
