<?php
declare(strict_types=1);

namespace Tests\Unit\Application\Commands\AddShoppingItem;

use Lindyhopchris\ShoppingList\Application\Commands\AddShoppingItem\AddShoppingItemFactory;
use Lindyhopchris\ShoppingList\Domain\ShoppingItemStack;
use PHPUnit\Framework\TestCase;

class AddShoppingItemFactoryTest extends TestCase
{
    public function test(): void
    {
        $factory = new AddShoppingItemFactory();

        $existing = $this->createMock(ShoppingItemStack::class);
        $existing->method('maxId')->willReturn(99);

        $actual = $factory->make($existing, 'Apples');

        $this->assertSame(100, $actual->getId());
        $this->assertSame('Apples', $actual->getName());
        $this->assertFalse($actual->isCompleted());
    }
}
