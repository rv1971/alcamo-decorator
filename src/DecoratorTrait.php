<?php

namespace alcamo\decorator;

/**
 * @namespace alcamo::decorator
 *
 * @brief Generic decorator trait
 */

/**
 * @brief Provides a decorator for $handler_
 *
 * This includes the methods that implement
 * - [Countable](https://www.php.net/manual/en/class.countable)
 * - [Iterator](https://www.php.net/manual/en/class.iterator)
 * - [IteratorAggregate](https://www.php.net/manual/en/class.iteratoraggregate)
 * - [ArrayAccess](https://www.php.net/manual/en/class.arrayaccess)
 *
 * These methods are written down explicitely, otherwise PHP would not
 * recognize that they are implemented, even though their implementation is
 * equivalent to the implicit use of the magic methods.
 *
 * It does not harm if the object in $handler_ does not support all of these
 * methods. The only effect of the implementation in the decorator object is
 * that attempting to call an unsupported method will fail at the $handler_
 * object instead of failing at the decorator object.
 *
 * @date Last reviewed 2025-10-22
 */
trait DecoratorTrait
{
    protected $handler_; ///< Handler object

    /**
     * @param $handler @copybrief $handler_
     */
    public function __construct(object $handler)
    {
        $this->handler_ = $handler;
    }

    public function __isset(string $name): bool
    {
        return isset($this->handler_->$name);
    }

    public function __unset(string $name): void
    {
        unset($this->handler_->$name);
    }

    public function __get(string $name)
    {
        return $this->handler_->$name;
    }

    public function __set(string $name, $value): void
    {
        $this->handler_->$name = $value;
    }

    public function __call(string $name, array $params)
    {
        return call_user_func_array([ $this->handler_, $name ], $params);
    }

    public function __toString(): string
    {
        return (string)$this->handler_;
    }

    /* == Countable interface == */

    public function count(): int
    {
        return $this->handler_->count();
    }

    /* == Iterator interface == */

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

    /* == IteratorAggregate interface == */

    public function getIterator()
    {
        return $this->handler_->getIterator();
    }

    /* == ArrayAccess interface == */

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
