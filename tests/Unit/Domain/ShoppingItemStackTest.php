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

    public function testPush(): ShoppingItemStack
    {
        $expected = [
            new ShoppingItem(1, 'Bananas'),
            new ShoppingItem(2, 'Apples'),
            new ShoppingItem(3, 'Pears'),
        ];

        $stack = new ShoppingItemStack($expected[0], $expected[1]);
        $actual = $stack->push($expected[2]);

        $this->assertCount(2, $stack);
        $this->assertSame([$expected[0], $expected[1]], $stack->all());

        $this->assertCount(3, $actual);
        $this->assertSame($expected, $actual->all());

        return $actual;
    }

    /**
     * @param ShoppingItemStack $items
     * @return void
     * @depends testPush
     */
    public function testItCannotPushDuplicateId(ShoppingItemStack $items): void
    {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Cannot add item with duplicate id.');

        $items->push(new ShoppingItem(2, 'Blah'));
    }

    /**
     * @param ShoppingItemStack $items
     * @return void
     * @depends testPush
     */
    public function testSelect(ShoppingItemStack $items): void
    {
        $actual = $items->select(
            static fn(ShoppingItem $item): bool => 2 === $item->getId()
        );

        $this->assertNotNull($actual);
        $this->assertSame(2, $actual->getId());
    }

    /**
     * @param ShoppingItemStack $items
     * @return void
     * @depends testPush
     */
    public function testSelectIsNull(ShoppingItemStack $items): void
    {
        $actual = $items->select(
            static fn(ShoppingItem $item): bool => 999 === $item->getId()
        );

        $this->assertNull($actual);
    }

    public function testMaxId(): void
    {
        $items = new ShoppingItemStack(
            new ShoppingItem(1, 'Bananas'),
            new ShoppingItem(3, 'Pears'),
            new ShoppingItem(2, 'Apples'),
        );

        $this->assertSame(3, $items->maxId());
    }
}
