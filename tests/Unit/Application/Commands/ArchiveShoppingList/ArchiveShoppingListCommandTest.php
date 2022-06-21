<?php

namespace Tests\Unit\Application\Commands\ArchiveShoppingList;

use Lindyhopchris\ShoppingList\Application\Commands\ArchiveShoppingList\ArchiveShoppingListCommand;
use Lindyhopchris\ShoppingList\Application\Commands\ArchiveShoppingList\ArchiveShoppingListModel;
use Lindyhopchris\ShoppingList\Application\Commands\ArchiveShoppingList\Validation\ArchiveShoppingListValidator;
use Lindyhopchris\ShoppingList\Domain\ShoppingList;
use Lindyhopchris\ShoppingList\Persistance\ShoppingListRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ArchiveShoppingListCommandTest extends TestCase
{
    /**
     * @var ShoppingListRepositoryInterface|MockObject
     */
    private ShoppingListRepositoryInterface|MockObject $repository;

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
            $this->repository = $this->createMock(ShoppingListRepositoryInterface::class),
            $this->createMock(ArchiveShoppingListValidator::class),
        );
    }

    public function test(): void
    {
        $mockList = $this->createMock(ShoppingList::class);

        $this->repository
            ->expects($this->once())
            ->method('findOrFail')
            ->with('my-groceries')
            ->willReturn($mockList);

        $mockList
            ->expects($this->once())
            ->method('setArchived')
            ->with(true)
            ->willReturnSelf();

        $this->repository
            ->expects($this->once())
            ->method('store')
            ->with($this->identicalTo($mockList));

        $this->command->execute(new ArchiveShoppingListModel('my-groceries'));
    }

}
