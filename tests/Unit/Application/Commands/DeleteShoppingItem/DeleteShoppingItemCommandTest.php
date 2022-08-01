<?php

namespace Tests\Unit\Application\Commands\DeleteShoppingItem;

use Lindyhopchris\ShoppingList\Application\Commands\DeleteShoppingItem\DeleteShoppingItemCommand;
use Lindyhopchris\ShoppingList\Application\Commands\DeleteShoppingItem\DeleteShoppingItemModel;
use Lindyhopchris\ShoppingList\Application\Commands\DeleteShoppingItem\Validation\DeleteShoppingItemValidator;
use Lindyhopchris\ShoppingList\Common\Validation\ValidationException;
use Lindyhopchris\ShoppingList\Common\Validation\ValidationMessageStack;
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
     * @var DeleteShoppingItemCommand
     */
    private DeleteShoppingItemCommand $command;

    /**
     * @var DeleteShoppingItemValidator|MockObject
     */
    private DeleteShoppingItemValidator|MockObject  $validator;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->command = new DeleteShoppingItemCommand(
            $this->repository = $this->createMock(ShoppingListRepositoryInterface::class),
            $this->validator = $this->createMock(DeleteShoppingItemValidator::class),
        );
    }

    public function testDeleteShoppingItemOnList(): void
    {
        // Given a shopping list with multiple items on it.
        $item1 = new ShoppingItem(1, 'Bananas', false);
        $item2 = new ShoppingItem(2, 'Apples', true);
        $item3 = new ShoppingItem(3, 'Pears', false);

        $list = $this->createMock(ShoppingList::class);
        $list->method('getItems')->willReturn(new ShoppingItemStack($item1, $item2, $item3));

        $model = new DeleteShoppingItemModel('my-groceries', 'Apples');

        // Expect the command to retrieve the list, then remove the item with the name "Apples" (item 2)
        $this->repository
            ->expects($this->once())
            ->method('findOrFail')
            ->with('my-groceries')
            ->willReturn($list);

        $list
            ->expects($this->once())
            ->method('removeItem')
            ->with($this->identicalTo($item2));

        $this->validator
            ->expects($this->once())
            ->method('validateOrFail')
            ->with($this->identicalTo($model));

        $this->repository
            ->expects($this->once())
            ->method('store')
            ->with($this->identicalTo($list));

        // Delete/remove that item on the list
        $this->command->execute($model);
    }

    public function testItValidatesBeforeDeletingNewItem(): void
    {
        $model = new DeleteShoppingItemModel('my-groceries', 'Apples');

        $this->validator
            ->expects($this->once())
            ->method('validateOrFail')
            ->willThrowException(new ValidationException(new ValidationMessageStack()));

        $this->repository
            ->expects($this->never())
            ->method($this->anything());

        $this->expectException(ValidationException::class);

        $this->command->execute($model);
    }
}
