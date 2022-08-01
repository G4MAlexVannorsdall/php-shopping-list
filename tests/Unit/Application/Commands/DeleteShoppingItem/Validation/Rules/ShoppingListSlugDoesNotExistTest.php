<?php

namespace Tests\Unit\Application\Commands\DeleteShoppingItem\Validation\Rules;

use Lindyhopchris\ShoppingList\Application\Commands\DeleteShoppingItem\DeleteShoppingItemModel;
use Lindyhopchris\ShoppingList\Application\Commands\DeleteShoppingItem\Validation\Rules\ShoppingListDoesNotExist;
use Lindyhopchris\ShoppingList\Persistance\ShoppingListRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ShoppingListSlugDoesNotExistTest extends TestCase
{
    /**
     * @var MockObject|ShoppingListRepositoryInterface
     */
    private MockObject $repository;

    /**
     * @var ShoppingListDoesNotExist
     */
    private ShoppingListDoesNotExist $rule;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->rule = new ShoppingListDoesNotExist(
            $this->repository = $this->createMock(ShoppingListRepositoryInterface::class),
        );
    }

    public function testValid(): void
    {
        // Given that the 'my-groceries' shopping list exists
        $this->repository
            ->expects($this->once())
            ->method('exists')
            ->with('my-groceries')
            ->willReturn(true);

        // When the delete shopping item model is validated with the slug 'my-groceries'
        $model = new DeleteShoppingItemModel('my-groceries', 'apples');
        $actual = $this->rule->validate($model);

        // Then the result will be valid.
        $this->assertFalse($actual->hasErrors());
    }

    public function testInvalid(): void
    {
        // Given that the 'my-groceries' shopping list does not exist
        $this->repository
            ->expects($this->once())
            ->method('exists')
            ->with('my-groceries')
            ->willReturn(false);

        // When the delete shopping item model is validated with the slug 'my-groceries'
        $model = new DeleteShoppingItemModel('my-groceries', 'apples');
        $actual = $this->rule->validate($model);

        // Then the result will not be valid.
        $this->assertTrue($actual->hasErrors());
        $this->assertSame(['Shopping list "my-groceries" does not exist.'], $actual->getMessages());
    }
}
