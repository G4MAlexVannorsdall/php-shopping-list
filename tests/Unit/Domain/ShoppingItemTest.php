<?php
declare(strict_types=1);

namespace Tests\Unit\Domain;

use Lindyhopchris\ShoppingList\Domain\ShoppingItem;
use PHPUnit\Framework\TestCase;

class ShoppingItemTest extends TestCase
{
    /**
     * @return ShoppingItem
     */
    public function testGetters(): ShoppingItem
    {
        $item = new ShoppingItem(3, 'Bananas');

        $this->assertSame(3, $item->getId());
        $this->assertSame('Bananas', $item->getName());
        $this->assertFalse($item->isCompleted());

        return $item;
    }

    /**
     * @param ShoppingItem $item
     * @depends testGetters
     */
    public function testMarkAsCompleted(ShoppingItem $item): void
    {
        $item->markAsCompleted();

        $this->assertTrue($item->isCompleted());
    }
}
