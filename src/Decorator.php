<?php

namespace alcamo\decorator;

/**
 * @brief Class using DecoratorTrait
 *
 * It is deliberate that no interfaces are indicated for this class. Whether
 * such a decorator class implements an interface such as Countable or
 * Iterator depends on the handler object used. Hence derived classes need to
 * declare support for the relevant interfaces as appropriate.
 *
 * @date Last reviewed 2025-10-22
 */
class Decorator
{
    use DecoratorTrait;
}
