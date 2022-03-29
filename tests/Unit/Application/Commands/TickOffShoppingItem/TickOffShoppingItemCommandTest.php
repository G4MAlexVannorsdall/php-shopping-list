<?php
declare(strict_types=1);

namespace Tests\Unit\Application\Commands\TickOffShoppingItem;

use Lindyhopchris\ShoppingList\Application\Commands\TickOffShoppingItem\TickOffShoppingItemCommand;
use Lindyhopchris\ShoppingList\Application\Commands\TickOffShoppingItem\TickOffShoppingItemModel;
use Lindyhopchris\ShoppingList\Application\Commands\TickOffShoppingItem\Validation\TickOffShoppingItemValidator;
use Lindyhopchris\ShoppingList\Common\Validation\ValidationException;
use Lindyhopchris\ShoppingList\Common\Validation\ValidationMessageStack;
use Lindyhopchris\ShoppingList\Domain\ShoppingItem;
use Lindyhopchris\ShoppingList\Domain\ShoppingItemSelector;
use Lindyhopchris\ShoppingList\Domain\ShoppingItemStack;
use Lindyhopchris\ShoppingList\Domain\ShoppingList;
use Lindyhopchris\ShoppingList\Persistance\ShoppingListRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class TickOffShoppingItemCommandTest extends TestCase
{
    /**
     * @var TickOffShoppingItemValidator|MockObject
     */
    private TickOffShoppingItemValidator|MockObject $validator;

    /**
     * @var ShoppingListRepositoryInterface|MockObject
     */
    private ShoppingListRepositoryInterface|MockObject $repository;

    /**
     * @var TickOffShoppingItemCommand
     */
    private TickOffShoppingItemCommand $command;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->command = new TickOffShoppingItemCommand(
            $this->validator = $this->createMock(TickOffShoppingItemValidator::class),
            $this->repository = $this->createMock(ShoppingListRepositoryInterface::class),
        );
    }

    public function test(): void
    {
        $model = new TickOffShoppingItemModel('my-groceries', 'Apples');

        $list = $this->createMock(ShoppingList::class);

        $list
            ->expects($this->once())
            ->method('getItems')
            ->willReturn($items = $this->createMock(ShoppingItemStack::class));

        $items
            ->expects($this->once())
            ->method('select')
            ->with($this->equalTo(new ShoppingItemSelector('Apples', false)))
            ->willReturn($item = $this->createMock(ShoppingItem::class));

        $item
            ->expects($this->once())
            ->method('markAsCompleted');

        $this->validator
            ->expects($this->once())
            ->method('validateOrFail')
            ->with($this->identicalTo($model));

        $this->repository
            ->expects($this->once())
            ->method('findOrFail')
            ->with('my-groceries')
            ->willReturn($list);

        $this->repository
            ->expects($this->once())
            ->method('store')
            ->with($this->identicalTo($list));

        $this->command->execute($model);
    }

    public function testItValidatesBeforeCreateNewItem(): void
    {
        $model = new TickOffShoppingItemModel('my-groceries', 'Apples');

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
