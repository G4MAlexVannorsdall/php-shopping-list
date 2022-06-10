<?php

namespace Tests\Unit\Application\Commands\ArchiveShoppingList;

use Lindyhopchris\ShoppingList\Application\Commands\ArchiveShoppingList\ArchiveShoppingListCommand;
use Lindyhopchris\ShoppingList\Application\Commands\ArchiveShoppingList\ArchiveShoppingListModel;
use Lindyhopchris\ShoppingList\Persistance\ShoppingListRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ArchiveShoppingListCommandTest extends TestCase
{
    /**
     * @var ShoppingListRepositoryInterface| MockObject
     */
    private ShoppingListRepositoryInterface| MockObject $repository;

    /**
     * @var ArchiveShoppingListCommand
     */
    private ArchiveShoppingListCommand $command;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->command = new ArchiveShoppingListCommand(
            $this->repository = $this->createMock(ShoppingListRepositoryInterface::class)
        );
    }

    public function testRetrieveList(): void
    {
        // Given a shopping list titled supplies
        $model = new ArchiveShoppingListModel('supplies');
        // When the repo fetches the shopping list
        $this->repository
            ->expects();

        // Then the list is shown
        $this->command->execute($model);
    }

    public function testMarkListAsArchived(): void
    {
        //Given a shopping list that is not archived
        // When the list is marked archived
        // Then the list is archived
    }

    public function testStoreArchivedList(): void
    {
        // Given a shopping list
        // When the list has the property isArchived to true
        // Then the archived list is stored
    }
}
