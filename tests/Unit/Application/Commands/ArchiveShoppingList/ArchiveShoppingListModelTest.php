<?php

namespace Tests\Unit\Application\Commands\ArchiveShoppingList;

use Lindyhopchris\ShoppingList\Application\Commands\ArchiveShoppingList\ArchiveShoppingListModel;
use PHPUnit\Framework\TestCase;

class ArchiveShoppingListModelTest extends TestCase
{
    /**
     * @return string
     */
    public function listProvider(): string
    {
        return 'groceries';
    }
    /**
     * @param string $list
     * @return void
     * @dataProvider listProvider
     */
    public function test(string $list): void
    {
        $model = new ArchiveShoppingListModel('groceries');

        $this->assertSame($list, $model->getList());
    }
}
