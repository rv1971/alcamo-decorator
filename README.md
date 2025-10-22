# Usage example

~~~
use alcamo\decorator\Decorator;
use Ds\Set;

class SetWithSum extends Decorator implements \Countable, \IteratorAggregate
{
    public function __construct($values)
    {
        parent::__construct(new Set($values));
    }

    public function getSum(): int
    {
        $result = 0;

        foreach ($this as $value) {
            $result += $value;
        }

        return $result;
    }
}

$set = new SetWithSum([ 42, 42, 7]);

echo "Count: " . count($set) . "\n";

echo "Sum: " . $set->getSum() . "\n";
~~~

This will output:

~~~
Count: 2
Sum: 49
~~~

# Overview

The trait `DecoratorTrait` implements the [Decorator
pattern](https://en.wikipedia.org/wiki/Decorator_pattern) for an
arbitrary object. The class `Decorator` uses this trait.

As in the example above, this can be used to create a class that adds
functionality to a class when creating a derived class is not possible.

All functionality of the enclosed object is exposed by the decorator
so that the decorator behaves just as the enclosed object, supporting,
for instance, the Countable, Iterator or ArrayAccess interface.
