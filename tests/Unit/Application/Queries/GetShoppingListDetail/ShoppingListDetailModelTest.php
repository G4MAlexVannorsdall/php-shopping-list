<?php
declare(strict_types=1);

namespace Tests\Unit\Application\Queries\GetShoppingListDetail;

use Lindyhopchris\ShoppingList\Application\Queries\GetShoppingListDetail\ShoppingItemDetailModel;
use Lindyhopchris\ShoppingList\Application\Queries\GetShoppingListDetail\ShoppingListDetailModel;
use PHPUnit\Framework\TestCase;

class ShoppingListDetailModelTest extends TestCase
{
    public function test(): void
    {
        $item1 = new ShoppingItemDetailModel(1, 'Apples', false);
        $item2 = new ShoppingItemDetailModel(2, 'Bananas', true);

        $list = new ShoppingListDetailModel(
            'my-groceries',
            'My Groceries',
            $items = [$item1, $item2],
        );

        $this->assertSame('my-groceries', $list->getSlug());
        $this->assertSame('My Groceries', $list->getName());
        $this->assertSame($items, $list->getItems());
        $this->assertSame($items, iterator_to_array($list));
        $this->assertCount(2, $list);
        $this->assertFalse($list->isEmpty());
    }

    public function testEmpty(): void
    {
        $list = new ShoppingListDetailModel('my-groceries', 'My Groceries', []);

        $this->assertCount(0, $list);
        $this->assertTrue($list->isEmpty());
    }
}
