<?php

namespace Tests\Unit\Application\Commands\DeleteShoppingList;

use Lindyhopchris\ShoppingList\Application\Commands\DeleteShoppingList\DeleteShoppingListCommand;
use Lindyhopchris\ShoppingList\Application\Commands\DeleteShoppingList\DeleteShoppingListModel;
use Lindyhopchris\ShoppingList\Domain\ShoppingList;
use Lindyhopchris\ShoppingList\Persistance\ShoppingListNotFoundException;
use Lindyhopchris\ShoppingList\Persistance\ShoppingListRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class DeleteShoppingListCommandTest extends TestCase
{
    /**
     * @var ShoppingListRepositoryInterface|MockObject
     */
    private ShoppingListRepositoryInterface|MockObject $repository;

    /**
     * @var DeleteShoppingListCommand
     */
    private DeleteShoppingListCommand $command;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->command = new DeleteShoppingListCommand(
            $this->repository = $this->createMock(ShoppingListRepositoryInterface::class));
    }

    public function test(): void
    {
        $model = new DeleteShoppingListModel('my-groceries');
        $mockList = $this->createMock(ShoppingList::class);

        $this->repository
            ->expects($this->once())
            ->method('findOrFail')
            ->willReturn($mockList);

        $this->repository
            ->expects($this->once())
            ->method('delete');

        $this->command->execute($model);
    }
}
