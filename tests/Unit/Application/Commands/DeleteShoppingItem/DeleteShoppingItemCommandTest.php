<?php

namespace Tests\Unit\Application\Commands\DeleteShoppingItem;

use Lindyhopchris\ShoppingList\Application\Commands\DeleteShoppingItem\DeleteShoppingItemCommand;
use Lindyhopchris\ShoppingList\Application\Commands\DeleteShoppingItem\DeleteShoppingItemModel;
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
     * @var DeleteShoppingItemCommand
     */
    private DeleteShoppingItemCommand $command;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->command = new DeleteShoppingItemCommand(
            $this->repository = $this->createMock(ShoppingListRepositoryInterface::class),
        );
    }

    public function testDeleteShoppingItemOnList(): void
    {
        // Given a shopping list with an item on it
        $model = new DeleteShoppingItemModel('my-groceries', 'Apples');

        // Then get item on the list
        $this->repository
            ->expects($this->once())
            ->method('findOrFail')
            ->with('my-groceries')
            ->willReturn($list = $this->createMock(ShoppingList::class));

        $list
            ->method('getItems')
            ->willReturn($items = $this->createMock(ShoppingItemStack::class));

        $list
            ->expects($this->once())
            ->method('remove')
            ->with($this->identicalTo($items));

        $this->repository
            ->expects($this->once())
            ->method('store')
            ->with($this->identicalTo($list));

        // Delete/remove that item on the list
        $this->command->execute($model);
    }
}
