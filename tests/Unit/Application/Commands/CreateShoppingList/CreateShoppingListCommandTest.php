<?php
declare(strict_types=1);

namespace Tests\Unit\Application\Commands\CreateShoppingList;

use Lindyhopchris\ShoppingList\Application\Commands\CreateShoppingList\CreateShoppingListCommand;
use Lindyhopchris\ShoppingList\Application\Commands\CreateShoppingList\CreateShoppingListModel;
use Lindyhopchris\ShoppingList\Application\Commands\CreateShoppingList\CreateShoppingListFactory;
use Lindyhopchris\ShoppingList\Application\Commands\CreateShoppingList\Validation\CreateShoppingListValidator;
use Lindyhopchris\ShoppingList\Common\Validation\ValidationException;
use Lindyhopchris\ShoppingList\Common\Validation\ValidationMessageStack;
use Lindyhopchris\ShoppingList\Domain\ShoppingList;
use Lindyhopchris\ShoppingList\Persistance\ShoppingListRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CreateShoppingListCommandTest extends TestCase
{
    /**
     * @var CreateShoppingListValidator|MockObject
     */
    private CreateShoppingListValidator|MockObject $validator;

    /**
     * @var CreateShoppingListFactory|MockObject
     */
    private CreateShoppingListFactory|MockObject $factory;

    /**
     * @var ShoppingListRepositoryInterface|MockObject
     */
    private ShoppingListRepositoryInterface|MockObject $repository;

    /**
     * @var CreateShoppingListCommand
     */
    private CreateShoppingListCommand $command;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->command = new CreateShoppingListCommand(
            $this->validator = $this->createMock(CreateShoppingListValidator::class),
            $this->factory = $this->createMock(CreateShoppingListFactory::class),
            $this->repository = $this->createMock(ShoppingListRepositoryInterface::class),
        );
    }

    public function test(): void
    {
        $model = new CreateShoppingListModel(
            'my-groceries',
            'My Groceries',
            false,

        );

        $this->validator
            ->expects($this->once())
            ->method('validateOrFail')
            ->with($this->identicalTo($model));

        $this->factory
            ->expects($this->once())
            ->method('make')
            ->with('my-groceries', 'My Groceries', null, false)
            ->willReturn($entity = $this->createMock(ShoppingList::class));

        $this->repository
            ->expects($this->once())
            ->method('store')
            ->with($this->identicalTo($entity));

        $this->command->execute($model);
    }

    public function testItValidatesBeforeCreatingNewEntity(): void
    {
        $model = new CreateShoppingListModel(
            'my-groceries',
            'My Groceries',
            false
        );

        $expected = new ValidationException(new ValidationMessageStack(), 'Boom!');

        $this->validator
            ->expects($this->once())
            ->method('validateOrFail')
            ->willThrowException($expected);

        $this->factory
            ->expects($this->never())
            ->method($this->anything());

        $this->repository
            ->expects($this->never())
            ->method($this->anything());

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Boom!');

        $this->command->execute($model);
    }
}
