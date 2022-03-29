<?php
declare(strict_types=1);

namespace Tests\Unit\Application\Commands\TickOffShoppingItem\Validation\Rules;

use Lindyhopchris\ShoppingList\Application\Commands\TickOffShoppingItem\TickOffShoppingItemModel;
use Lindyhopchris\ShoppingList\Application\Commands\TickOffShoppingItem\Validation\Rules\ShoppingItemExistsAndIsNotTickedOff;
use Lindyhopchris\ShoppingList\Domain\ShoppingItem;
use Lindyhopchris\ShoppingList\Domain\ShoppingItemSelector;
use Lindyhopchris\ShoppingList\Domain\ShoppingItemStack;
use Lindyhopchris\ShoppingList\Domain\ShoppingList;
use Lindyhopchris\ShoppingList\Persistance\ShoppingListRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ShoppingItemExistsAndIsNotTickedOffTest extends TestCase
{
    /**
     * @var ShoppingListRepositoryInterface|MockObject
     */
    private ShoppingListRepositoryInterface|MockObject $repository;

    /**
     * @var ShoppingItemExistsAndIsNotTickedOff
     */
    private ShoppingItemExistsAndIsNotTickedOff $rule;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->rule = new ShoppingItemExistsAndIsNotTickedOff(
            $this->repository = $this->createMock(ShoppingListRepositoryInterface::class),
        );
    }

    public function testItPasses(): void
    {
        $model = new TickOffShoppingItemModel('my-groceries', 'Apples');

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

    public function testListDoesNotExist(): void
    {
        $model = new TickOffShoppingItemModel('my-groceries', 'Apples');

        $this->repository
            ->expects($this->once())
            ->method('find')
            ->with('my-groceries')
            ->willReturn(null);

        $actual = $this->rule->validate($model);

        $this->assertTrue($actual->hasErrors());
        $this->assertSame(['Shopping list "my-groceries" does not exist.'], $actual->getMessages());
    }

    public function testItemDoesNotExist(): void
    {
        $model = new TickOffShoppingItemModel('my-groceries', 'Apples');

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
            ['Shopping item "Apples" does not exist or is already marked as completed.'],
            $actual->getMessages(),
        );
    }
}
