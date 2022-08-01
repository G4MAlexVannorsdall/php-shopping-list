<?php

namespace Tests\Unit\Application\Commands\DeleteShoppingItem\Validation\Rules;

use Lindyhopchris\ShoppingList\Application\Commands\DeleteShoppingItem\DeleteShoppingItemModel;
use Lindyhopchris\ShoppingList\Application\Commands\DeleteShoppingItem\Validation\Rules\ShoppingItemAlreadyDeleted;
use Lindyhopchris\ShoppingList\Domain\ShoppingItem;
use Lindyhopchris\ShoppingList\Domain\ShoppingItemSelector;
use Lindyhopchris\ShoppingList\Domain\ShoppingItemStack;
use Lindyhopchris\ShoppingList\Domain\ShoppingList;
use Lindyhopchris\ShoppingList\Persistance\ShoppingListRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ShoppingItemAlreadyDeletedTest extends TestCase
{
    /**
     * @var ShoppingListRepositoryInterface|MockObject
     */
    private ShoppingListRepositoryInterface|MockObject $repository;

    /**
     * @var ShoppingItemAlreadyDeleted
     */
    private ShoppingItemAlreadyDeleted $rule;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->rule = new ShoppingItemAlreadyDeleted (
            $this->repository = $this->createMock(ShoppingListRepositoryInterface::class),
        );
    }

    public function testItemDoesNotExist(): void
    {
        $model = new DeleteShoppingItemModel('my-groceries', 'Apples');

        $this->repository
            ->expects($this->once())
            ->method('find')
            ->with('my-groceries')
            ->willReturn($list = $this->createMock(ShoppingList::class));

        $list
            ->expects($this->once())
            ->method('getItems')
            ->willReturn($items = $this->createMock(ShoppingItemStack::class));

        $items
            ->expects($this->once())
            ->method('select')
            ->with($this->equalTo(new ShoppingItemSelector('Apples', false)))
            ->willReturn(null);

        $actual = $this->rule->validate($model);

        $this->assertTrue($actual->hasErrors());
        $this->assertSame(
            ['Shopping item "Apples" does not exist or has already been deleted.'],
            $actual->getMessages(),
        );
    }

    public function testListDoesNotExist(): void
    {
        $model = new DeleteShoppingitemModel('supplies', 'tape');

        $this->repository
            ->expects($this->once())
            ->method('find')
            ->with('supplies')
            ->willReturn(null);

        $actual = $this->rule->validate($model);

        $this->assertTrue($actual->hasErrors());
        $this->assertSame(['Shopping list "supplies" does not exist.'], $actual->getMessages());
    }

    public function testItPasses(): void
    {
        $model = new DeleteShoppingItemModel('my-groceries', 'Apples');

        $this->repository
            ->expects($this->once())
            ->method('find')
            ->with('my-groceries')
            ->willReturn($list = $this->createMock(ShoppingList::class));

        $list
            ->expects($this->once())
            ->method('getItems')
            ->willReturn($items = $this->createMock(ShoppingItemStack::class));

        $items
            ->expects($this->once())
            ->method('select')
            ->with($this->equalTo(new ShoppingItemSelector('Apples', false)))
            ->willReturn($this->createMock(ShoppingItem::class));

        $actual = $this->rule->validate($model);

        $this->assertFalse($actual->hasErrors());
    }

}
