<?php

namespace Tests\Unit\Application\Commands\ArchiveShoppingList\Validation\Rules;

use Lindyhopchris\ShoppingList\Application\Commands\ArchiveShoppingList\ArchiveShoppingListModel;
use Lindyhopchris\ShoppingList\Application\Commands\ArchiveShoppingList\Validation\Rules\ShoppingListAlreadyArchived;
use Lindyhopchris\ShoppingList\Domain\ShoppingList;
use Lindyhopchris\ShoppingList\Persistance\ShoppingListRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ShoppingListAlreadyArchivedTest extends TestCase
{
    /**
     * @var MockObject
     */
    private MockObject $repository;

    /**
     * @var ShoppingListAlreadyArchived
     */
    private ShoppingListAlreadyArchived $rule;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->rule = new ShoppingListAlreadyArchived(
            $this->repository = $this->createMock(ShoppingListRepositoryInterface::class),
        );
    }

    public function testItIsArchived(): void
    {
        // Given a 'my-groceries' shopping list that exists and is archived.
        $mockList = $this->createMock(ShoppingList::class);
        $mockList->method('isArchived')->willReturn(true);

        $this->repository
            ->expects($this->once())
            ->method('find')
            ->with('my-groceries')
            ->willReturn($mockList);

        // When the archive shopping list model is validated with the slug 'my-groceries'
        $model = new ArchiveShoppingListModel('my-groceries');
        $actual = $this->rule->validate($model);

        // Then the result has errors saying the list is archived.
        $this->assertTrue($actual->hasErrors());
        $this->assertSame(['Shopping list "my-groceries" is already archived.'], $actual->getMessages());
    }

    public function testItIsNotArchived(): void
    {
        // Given a 'my-groceries' shopping list that exists and is archived.
        $mockList = $this->createMock(ShoppingList::class);
        $mockList->method('isArchived')->willReturn(false);

        $this->repository
            ->expects($this->once())
            ->method('find')
            ->with('my-groceries')
            ->willReturn($mockList);

        // When the archive shopping list model is validated with the slug 'my-groceries'
        $model = new ArchiveShoppingListModel('my-groceries');
        $actual = $this->rule->validate($model);

        // Then the result is valid
        $this->assertFalse($actual->hasErrors());
    }

    public function testItDoesntExist(): void
    {
        // Given a 'my-groceries' shopping list does not exist
        $this->repository
            ->expects($this->once())
            ->method('find')
            ->with('my-groceries')
            ->willReturn(null);

        // When the archive shopping list model is validated with the slug 'my-groceries'
        $model = new ArchiveShoppingListModel('my-groceries');
        $actual = $this->rule->validate($model);

        // Then the result is valid (a non-existing shopping list is not considered archived).
        $this->assertFalse($actual->hasErrors());
    }
}
