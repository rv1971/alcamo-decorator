<?php

namespace alcamo\decorator;

use alcamo\exception\ReadonlyViolation;
use PHPUnit\Framework\TestCase;

class MyMultiDecorated implements \ArrayAccess, \Countable
{
    use MultiDecoratedArrayAccessTrait;

    public function __construct()
    {
        $this->addDecorator(new DecoratorA());
    }

    public function count(): int
    {
        return count($this->decorators_);
    }
}

class DecoratorA extends Decorator
{
    public function getHandler()
    {
        return $this->handler_;
    }
}

class DecoratorB extends DecoratorA
{
}

class DecoratorC extends DecoratorA
{
}

class DecoratorD extends DecoratorC
{
}

class MultiDecoratedArrayAccessTest extends TestCase
{
    public function testBasics(): void
    {
        $multi = new MyMultiDecorated();

        $this->assertSame(1, count($multi));

        $this->assertNull($multi['foo']);

        $this->assertNull($multi->getDecorator('foo'));

        $decoratorA = $multi[DecoratorA::class];

        $this->assertInstanceof(DecoratorA::class, $decoratorA);

        $this->assertSame($multi, $decoratorA->getHandler());

        $this->assertSame($decoratorA, $multi->getDecorator(DecoratorA::class));

        $decoratorB = new DecoratorB();

        $decoratorD = new DecoratorD();

        $multi->addDecorators([ 'B' => $decoratorB, $decoratorD ]);

        $this->assertSame($decoratorB, $multi['B']);

        $this->assertSame($multi, $decoratorB->getHandler());

        $this->assertSame(3, count($multi));

        $this->assertSame($decoratorD, $multi[DecoratorC::class]);

        $this->assertSame(4, count($multi));

        $this->assertSame($multi, $decoratorD->getHandler());

        $multi->addDecorator($decoratorD, 'D');

        $this->assertSame($decoratorD, $multi['D']);
    }

    public function testSet()
    {
        $a = new MyMultiDecorated();

        $this->expectException(ReadonlyViolation::class);
        $this->expectExceptionMessage(
            'Attempt to modify readonly object <' . MyMultiDecorated::class
            . '> in method offsetSet()'
        );

        $a['foo'] = new DecoratorA();
    }

    public function testUnset()
    {
        $a = new MyMultiDecorated();

        $this->expectException(ReadonlyViolation::class);
        $this->expectExceptionMessage(
            'Attempt to modify readonly object <' . MyMultiDecorated::class
            . '> in method offsetUnset()'
        );

        unset($a['foo']);
    }
}
