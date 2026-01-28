<?php

namespace alcamo\decorator;

/**
 * @brief Class featuring multiple decorators indexed by their class name
 *
 * @date Last reviewed 2026-01-28
 */
trait MultiDecoratedTrait
{
    private $decorators_ = []; /// objects with DecoratorTrait

    /**
     * @brief Look for a decorator by class name.
     *
     * If the given class name is not found in the decorators, look for the
     * first one that is derived from the requested name. If found, add it to
     * the decorators to speed up future search for the same name.
     */
    public function getDecorator(string $name): ?object
    {
        if (isset($this->decorators_[$name])) {
            return $this->decorators_[$name];
        }

        foreach ($this->decorators_ as $decorator) {
            if ($decorator instanceof $name) {
                $this->decorators_[$name] = $decorator;

                return $decorator;
            }
        }

        return null;
    }

    /// Add a decorator object and set its handler to the present object
    public function addDecorator(object $decorator, ?string $name = null): void
    {
        $decorator->setHandler($this);
        $this->decorators_[$name ?? get_class($decorator)] = $decorator;
    }

    /// Add multiple decorator objects
    public function addDecorators(iterable $decorators): void
    {
        foreach ($decorators as $decorator) {
            $this->addDecorator($decorator);
        }
    }
}
