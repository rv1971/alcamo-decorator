<?php

namespace alcamo\decorator;

/**
 * @brief Decorator that delegates the Iterator methods to the handler
 *
 * The needed methods are written down explicitely because otherwise PHP would
 * not recognize that they are implemented, even though their implementation
 * is equivalent to the implicit use of the magic methods.
 *
 * @date Last reviewed 2026-01-29
 */
trait IteratorDecoratorTrait
{
    public function rewind(): void
    {
        $this->handler_->rewind();
    }

    public function current()
    {
        return $this->handler_->current();
    }

    public function key()
    {
        return $this->handler_->key();
    }

    public function next(): void
    {
        $this->handler_->next();
    }

    public function valid(): bool
    {
        return $this->handler_->valid();
    }
}
