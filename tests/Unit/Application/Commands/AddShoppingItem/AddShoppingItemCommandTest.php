<?php
declare(strict_types=1);

namespace Tests\Unit\Application\Commands\AddShoppingItem;

use Lindyhopchris\ShoppingList\Application\Commands\AddShoppingItem\AddShoppingItemCommand;
use Lindyhopchris\ShoppingList\Application\Commands\AddShoppingItem\AddShoppingItemModel;
use Lindyhopchris\ShoppingList\Application\Commands\AddShoppingItem\AddShoppingItemFactory;
use Lindyhopchris\ShoppingList\Application\Commands\AddShoppingItem\Validation\AddShoppingItemValidator;
use Lindyhopchris\ShoppingList\Common\Validation\ValidationException;
use Lindyhopchris\ShoppingList\Common\Validation\ValidationMessageStack;
use Lindyhopchris\ShoppingList\Domain\ShoppingItem;
use Lindyhopchris\ShoppingList\Domain\ShoppingItemStack;
use Lindyhopchris\ShoppingList\Domain\ShoppingList;
use Lindyhopchris\ShoppingList\Persistance\ShoppingListRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class AddShoppingItemCommandTest extends TestCase
{
    /**
     * @var AddShoppingItemValidator|MockObject
     */
    private AddShoppingItemValidator|MockObject $validator;

    /**
     * @var AddShoppingItemFactory|MockObject
     */
    private AddShoppingItemFactory|MockObject $factory;

    /**
     * @var ShoppingListRepositoryInterface|MockObject
     */
    private ShoppingListRepositoryInterface|MockObject $repository;

    /**
     * @var AddShoppingItemCommand
     */
    private AddShoppingItemCommand $command;

    protected function setUp(): void
    {
        parent::setUp();

        $this->command = new AddShoppingItemCommand(
            $this->validator = $this->createMock(AddShoppingItemValidator::class),
            $this->factory = $this->createMock(AddShoppingItemFactory::class),
            $this->repository = $this->createMock(ShoppingListRepositoryInterface::class),
        );
    }

    public function test(): void
    {
        $model = new AddShoppingItemModel('my-groceries', 'Apples');

        $this->validator
            ->expects($this->once())
            ->method('validateOrFail')
            ->with($this->identicalTo($model));

        $this->repository
            ->expects($this->once())
            ->method('findOrFail')
            ->with('my-groceries')
            ->willReturn($list = $this->createMock(ShoppingList::class));

        $list
            ->method('getItems')
            ->willReturn($items = $this->createMock(ShoppingItemStack::class));

        $this->factory
            ->method('make')
            ->with($this->identicalTo($items), 'Apples')
            ->willReturn($item = $this->createMock(ShoppingItem::class));

        $list
            ->expects($this->once())
            ->method('addItem')
            ->with($this->identicalTo($item));

        $this->repository
            ->expects($this->once())
            ->method('store')
            ->with($this->identicalTo($list));

        $this->command->execute($model);
    }

    public function testItValidatesBeforeCreateNewItem(): void
    {
        $model = new AddShoppingItemModel('my-groceries', 'Apples');

        $this->validator
            ->expects($this->once())
            ->method('validateOrFail')
            ->willThrowException(new ValidationException(new ValidationMessageStack()));

        $this->factory
            ->expects($this->never())
            ->method($this->anything());

        $this->repository
            ->expects($this->never())
            ->method($this->anything());

        $this->expectException(ValidationException::class);

        $this->command->execute($model);
    }
}
