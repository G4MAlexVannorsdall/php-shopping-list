<?php

namespace Tests\Unit\Application\Commands\ArchiveShoppingList;

use Lindyhopchris\ShoppingList\Application\Commands\ArchiveShoppingList\ArchiveShoppingListModel;
use PHPUnit\Framework\TestCase;

class ArchiveShoppingListModelTest extends TestCase
{
    /**
     * @return void
     */
    public function test(): void
    {
        $model = new ArchiveShoppingListModel('groceries');

        $this->assertSame('groceries', $model->getList());
    }
}
