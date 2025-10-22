<?php

namespace alcamo\decorator;

use Ds\Set;
use PHPUnit\Framework\TestCase;

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

class ExampleTest extends TestCase
{
    public function testSum(): void
    {
        $set = new SetWithSum([ 42, 42, 7]);

        $this->assertSame(2, count($set));

        $this->assertSame(49, $set->getSum());
    }
}
