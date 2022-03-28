<?php
declare(strict_types=1);

namespace Tests\Unit\Application\Commands\AddShoppingItem\Validation\Rules;

use Lindyhopchris\ShoppingList\Application\Commands\AddShoppingItem\AddShoppingItemModel;
use Lindyhopchris\ShoppingList\Application\Commands\AddShoppingItem\Validation\Rules\ShoppingListExists;
use Lindyhopchris\ShoppingList\Persistance\ShoppingListRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ShoppingListExistsTest extends TestCase
{
    /**
     * @var ShoppingListRepositoryInterface|MockObject
     */
    private ShoppingListRepositoryInterface|MockObject $repository;

    /**
     * @var ShoppingListExists
     */
    private ShoppingListExists $rule;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->rule = new ShoppingListExists(
            $this->repository = $this->createMock(ShoppingListRepositoryInterface::class),
        );
    }

    public function testItExists(): void
    {
        $model = new AddShoppingItemModel('my-groceries', 'Apples');

        $this->repository
            ->expects($this->once())
            ->method('exists')
            ->with('my-groceries')
            ->willReturn(true);

        $actual = $this->rule->validate($model);

        $this->assertFalse($actual->hasErrors());
    }

    public function testItDoesntExist(): void
    {
        $model = new AddShoppingItemModel('my-groceries', 'Apples');

        $this->repository
            ->expects($this->once())
            ->method('exists')
            ->with('my-groceries')
            ->willReturn(false);

        $actual = $this->rule->validate($model);

        $this->assertTrue($actual->hasErrors());
        $this->assertSame(['Shopping list "my-groceries" does not exist.'], $actual->getMessages());
    }
}
