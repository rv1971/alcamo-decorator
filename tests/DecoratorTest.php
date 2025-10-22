<?php

namespace alcamo\decorator;

use PHPUnit\Framework\TestCase;

class FooBar
{
    public $foo;
    public $bar;

    public function __construct(string $foo, string $bar)
    {
        $this->foo = $foo;
        $this->bar = $bar;
    }
}

class FooBarDecorator extends Decorator
{
    public function __construct(string $foo, string $bar)
    {
        parent::__construct(new FooBar($foo, $bar));
    }
}

class MyString
{
    private $text_;

    public function __construct(string $text)
    {
        $this->text_ = $text;
    }

    public function __toString(): string
    {
        return $this->text_;
    }
}

class ArrayDecorator extends Decorator implements \Countable, \IteratorAggregate, \ArrayAccess
{
    public function __construct(array $data)
    {
        parent::__construct(new \ArrayObject($data));
    }
}

class ObjectStorageDecorator extends Decorator implements \Countable, \Iterator, \ArrayAccess
{
    public function __construct(array $data)
    {
        parent::__construct(new \SplObjectStorage());

        foreach ($data as $key => $value) {
            $this->handler_[$value] = $key;
        }
    }
}

class DecoratorTest extends TestCase
{
    public function testFooBarDecorator(): void
    {
        $decorator = new FooBarDecorator('FOO', 'BAR');

        $this->assertTrue(isset($decorator->foo));
        $this->assertTrue(isset($decorator->bar));
        $this->assertSame('FOO', $decorator->foo);
        $this->assertSame('BAR', $decorator->bar);

        $decorator->foo = 'Foo';
        $this->assertSame('Foo', $decorator->foo);

        unset($decorator->bar);
        $this->assertFalse(isset($decorator->bar));
    }

    public function testMyStringDecorator(): void
    {
        $text = 'Lorem ipsum';

        $decorator = new Decorator(new MyString($text));

        $this->assertSame($text, (string)$decorator);
    }

    public function testArrayDecorator(): void
    {
        $data = [ 'foo', 'bar', 'baz' ];

        $decorator = new ArrayDecorator($data);

        $this->assertSame(count($data), count($decorator));

        foreach ($decorator as $key => $value) {
            $this->assertSame($data[$key], $value);

            $this->assertTrue(isset($decorator[$key]));
            $this->assertSame($data[$key], $decorator[$key]);
        }

        $this->assertSame($data, $decorator->getArrayCopy());

        $decorator[1] = 'BAR';
        $this->assertSame('BAR', $decorator[1]);

        unset($decorator[1]);
        $this->assertFalse(isset($decorator[1]));
    }

    public function testObjectStorageDecorator(): void
    {
        $data = [
            'foo' => (object)[ 'id' => 'FOO' ],
            'bar' => (object)[ 'id' => 'BAR' ],
            'baz' => (object)[ 'id' => 'BAZ' ],
        ];

        $decorator = new ObjectStorageDecorator($data);

        $this->assertSame(count($data), count($decorator));

        foreach ($decorator as $key => $value) {
            $this->assertSame(strtolower($value->id), $decorator[$value]);
        }
    }
}
