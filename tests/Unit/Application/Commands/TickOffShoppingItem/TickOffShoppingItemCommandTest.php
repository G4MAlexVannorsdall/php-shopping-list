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
use Lindyhopchris\ShoppingList\Domain\ValueObjects\Slug;
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

    public function testItTicksOffItemAndDoesNotAutoArchiveList(): void
    {
        // Given a shopping list that has only one item that is not complete
        $item1 = new ShoppingItem(1, 'Bananas', true);
        $item2 = new ShoppingItem(2, 'Apples', true);
        $item3 = new ShoppingItem(3, 'Pears', false);

        $model = new TickOffShoppingItemModel('my-groceries', 3);

        $list = $this->createMock(ShoppingList::class);

        $list->method('getItems')->willReturn(new ShoppingItemStack($item1, $item2, $item3));

        $list
            ->expects($this->never())
            ->method('setArchived');

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

    public function testItTicksOffItemAndDoesAutoArchiveList(): void
    {
        // Given a shopping list that has only one item that is not complete
        $item1 = new ShoppingItem(1, 'Bananas', true);
        $item2 = new ShoppingItem(2, 'Apples', true);
        $item3 = new ShoppingItem(3, 'Pears', false);

        $model = new TickOffShoppingItemModel('my-groceries', 3);

        $list = new ShoppingList(
            new Slug('my-groceries'),
            'My Groceries',
            false,
            new ShoppingItemStack($item1, $item2, $item3),
        );

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
            ->with($this->callback(function (ShoppingList $actual) use ($list): bool  {
                $this->assertSame($list, $actual);
                $this->assertTrue($list->isArchived(), 'it is archived');
                return true;
            }));

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
