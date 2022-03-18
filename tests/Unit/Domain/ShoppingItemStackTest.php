<?php
declare(strict_types=1);

namespace Tests\Unit\Domain;

use Lindyhopchris\ShoppingList\Domain\ShoppingItem;
use Lindyhopchris\ShoppingList\Domain\ShoppingItemStack;
use PHPUnit\Framework\TestCase;

class ShoppingItemStackTest extends TestCase
{
    public function testEmpty(): void
    {
        $stack = new ShoppingItemStack();

        $this->assertCount(0, $stack);
        $this->assertTrue($stack->isEmpty());
        $this->assertFalse($stack->isNotEmpty());
    }

    public function test(): void
    {
        $expected = [
            new ShoppingItem(1, 'Bananas'),
            new ShoppingItem(2, 'Apples'),
            new ShoppingItem(3, 'Pears'),
        ];

        $stack = new ShoppingItemStack(...$expected);

        $this->assertCount(3, $stack);
        $this->assertSame($expected, $stack->all());
        $this->assertSame($expected, iterator_to_array($stack));
    }

    public function testPush(): void
    {
        $expected = [
            new ShoppingItem(1, 'Bananas'),
            new ShoppingItem(2, 'Apples'),
            new ShoppingItem(3, 'Pears'),
        ];

        $stack = new ShoppingItemStack($expected[0], $expected[1]);

        $this->assertSame($stack, $stack->push($expected[2]));
        $this->assertSame($expected, $stack->all());
    }
}
