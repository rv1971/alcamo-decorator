<?php

namespace alcamo\decorator;

use alcamo\exception\Locked;

/**
 * @namespace alcamo::decorator
 *
 * @brief Generic decorator trait
 */

/**
 * @brief Decorator for $handler_
 *
 * @date Last reviewed 2026-01-29
 */
trait DecoratorTrait
{
    protected $handler_; ///< Handler object

    public function __construct(?object $handler = null)
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

    public function setHandler(object $handler)
    {
        if (isset($this->handler_) && $handler !== $this->handler_) {
            /** @throw alcamo::exception::Locked if the handler has already
             *  been set upon construction and is different from the given
             *  handler. */
            throw (new Locked())->setMessageContext(
                [ 'extraMessage' => 'handler already set' ]
            );
        }

        $this->handler_ = $handler;
    }
}
