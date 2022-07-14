<?php

namespace Tests\Unit\Application\Commands\DeleteShoppingList;

use Lindyhopchris\ShoppingList\Application\Commands\DeleteShoppingList\DeleteShoppingListModel;
use PHPUnit\Framework\TestCase;

class DeleteShoppingListModelTest extends TestCase
{
    /**
     * @return void
     */
    public function test(): void
    {
        $model = new DeleteShoppingListModel('groceries');

        $this->assertSame('groceries', $model->getList());
    }
}
