<?php

namespace Tests\Unit\Application\Commands\DeleteShoppingItem;

use Lindyhopchris\ShoppingList\Application\Commands\DeleteShoppingItem\DeleteShoppingItemModel;
use PHPUnit\Framework\TestCase;

class DeleteShoppingItemModelTest extends TestCase
{
    /**
     * @return array
     */
    public function itemProvider(): array
    {
        return [
            ['Apples', 'Apples'],
            [1, 1],
            ['3', 3],
            ['999', 999],
        ];
    }

    /**
     * @param string|int $item
     * @param string|int $expectedItem
     * @return void
     * @dataProvider itemProvider
     */
    public function test(string|int $item, string|int $expectedItem): void
    {
        $model = new DeleteShoppingItemModel('my-groceries', $item);

        $this->assertSame('my-groceries', $model->getList());
        $this->assertSame($expectedItem, $model->getItem());
        $this->assert ($expectedItem, $model->getItem()) //Need to assert that the item is deleted here
    }
}
