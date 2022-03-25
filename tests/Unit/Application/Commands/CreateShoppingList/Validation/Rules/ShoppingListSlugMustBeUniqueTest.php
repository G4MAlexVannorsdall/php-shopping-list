<?php
declare(strict_types=1);

namespace Tests\Unit\Application\Commands\CreateShoppingList\Validation\Rules;

use Lindyhopchris\ShoppingList\Application\Commands\CreateShoppingList\CreateShoppingListModel;
use Lindyhopchris\ShoppingList\Application\Commands\CreateShoppingList\Validation\Rules\ShoppingListSlugMustBeUnique;
use Lindyhopchris\ShoppingList\Persistance\ShoppingListRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ShoppingListSlugMustBeUniqueTest extends TestCase
{
    /**
     * @var ShoppingListRepositoryInterface|MockObject
     */
    private ShoppingListRepositoryInterface|MockObject $repository;

    /**
     * @var ShoppingListSlugMustBeUnique
     */
    private ShoppingListSlugMustBeUnique $rule;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->rule = new ShoppingListSlugMustBeUnique(
            $this->repository = $this->createMock(ShoppingListRepositoryInterface::class),
        );
    }

    public function testValid(): void
    {
        $model = new CreateShoppingListModel('my-groceries', 'My Groceries');

        $this->repository
            ->expects($this->once())
            ->method('exists')
            ->with('my-groceries')
            ->willReturn(false);

        $actual = $this->rule->validate($model);

        $this->assertFalse($actual->hasErrors());
    }

    public function testInvalid(): void
    {
        $model = new CreateShoppingListModel('my-groceries', 'My Groceries');

        $this->repository
            ->expects($this->once())
            ->method('exists')
            ->with('my-groceries')
            ->willReturn(true);

        $actual = $this->rule->validate($model);

        $this->assertTrue($actual->hasErrors());
        $this->assertSame(['Shopping list "my-groceries" already exists.'], $actual->getMessages());
    }
}
