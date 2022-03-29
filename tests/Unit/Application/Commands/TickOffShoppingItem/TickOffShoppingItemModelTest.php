<?php
declare(strict_types=1);

namespace Tests\Unit\Application\Commands\TickOffShoppingItem;

use Lindyhopchris\ShoppingList\Application\Commands\TickOffShoppingItem\TickOffShoppingItemModel;
use PHPUnit\Framework\TestCase;

class TickOffShoppingItemModelTest extends TestCase
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
        $model = new TickOffShoppingItemModel('my-groceries', $item);

        $this->assertSame('my-groceries', $model->getList());
        $this->assertSame($expectedItem, $model->getItem());
    }
}
