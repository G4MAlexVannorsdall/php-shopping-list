<?php

namespace Tests\Unit\Application\Commands\DeleteShoppingItem;

use Lindyhopchris\ShoppingList\Application\Commands\DeleteShoppingItem;
use Lindyhopchris\ShoppingList\Application\Commands\DeleteShoppingItem\DeleteShoppingItemModel;
use Lindyhopchris\ShoppingList\Domain\ShoppingItem;
use Lindyhopchris\ShoppingList\Domain\ShoppingItemStack;
use Lindyhopchris\ShoppingList\Domain\ShoppingList;
use Lindyhopchris\ShoppingList\Persistance\ShoppingListRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class DeleteShoppingItemCommand extends TestCase
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

    public function test(): void
    {
        // Given a shopping list with items on it
        $item1 = new ShoppingItem(1, 'Bananas', false);
        $item2 = new ShoppingItem(2, 'Apples', true);
        $item3 = new ShoppingItem(3, 'Pears', false);

        $model = new DeleteShoppingItemModel('my-groceries', 3);

        $list = $this->createMock(ShoppingList::class);

        $list->method('getItems')->willReturn(new ShoppingItemStack($item1, $item2, $item3));

        $list
            ->expects($this->once())
            ->method('remove');
    }
}
