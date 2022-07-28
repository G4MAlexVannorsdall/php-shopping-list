<?php

namespace Tests\Unit\Application\Commands\DeleteShoppingItem;

use Lindyhopchris\ShoppingList\Application\Commands\DeleteShoppingItem\DeleteShoppingItemModel;
use Lindyhopchris\ShoppingList\Domain\ShoppingItem;
use Lindyhopchris\ShoppingList\Domain\ShoppingItemStack;
use Lindyhopchris\ShoppingList\Domain\ShoppingList;
use Lindyhopchris\ShoppingList\Persistance\ShoppingListRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class DeleteShoppingItemCommandTest extends TestCase
{
    /**
     * @var ShoppingListRepositoryInterface|MockObject
     */
    private ShoppingListRepositoryInterface|MockObject $repository;

    /**
     * @var DeleteShoppingItemCommandTest
     */
    private DeleteShoppingItemCommandTest $command;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->command = new DeleteShoppingItemCommandTest(
            $this->repository = $this->createMock(ShoppingListRepositoryInterface::class),
        );
    }

    public function testDeleteShoppingItemOnList(): void
    {
        // Given a shopping list with an item on it
        $item1 = new ShoppingItem(1, 'Bananas', true);
        $item2 = new ShoppingItem(2, 'Apples', true);
        $item3 = new ShoppingItem(3, 'Pears', false);

        $model = new DeleteShoppingItemModel('my-groceries', 3);

        $list = $this->createMock(ShoppingList::class);
        // Then get item on the list
        $list->method('getItem')->willReturn(new ShoppingItemStack($item1, $item2, $item3));
        // Delete/remove that item on the list
        $list
            ->expects($this->once())
            ->method('remove')
            ->with('my-groceries');

        $this->repository
            ->expects($this->once())
            ->method('findOrFail')
            ->with('my-groceries')
            ->willReturn($list);

        $this->command->execute($model);
    }
}
