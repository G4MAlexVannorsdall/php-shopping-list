<?php
declare(strict_types=1);

namespace Tests\Unit\Application\Queries\GetShoppingListDetail;

use Lindyhopchris\ShoppingList\Application\Queries\GetShoppingListDetail\GetShoppingListDetailQuery;
use Lindyhopchris\ShoppingList\Application\Queries\GetShoppingListDetail\ShoppingItemDetailModel;
use Lindyhopchris\ShoppingList\Application\Queries\GetShoppingListDetail\ShoppingListDetailModel;
use Lindyhopchris\ShoppingList\Domain\ShoppingItem;
use Lindyhopchris\ShoppingList\Domain\ShoppingItemStack;
use Lindyhopchris\ShoppingList\Domain\ShoppingList;
use Lindyhopchris\ShoppingList\Domain\Slug;
use Lindyhopchris\ShoppingList\Persistance\ShoppingListRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class GetShoppingListDetailQueryTest extends TestCase
{
    /**
     * @var ShoppingListRepositoryInterface|MockObject
     */
    private ShoppingListRepositoryInterface|MockObject $repository;

    /**
     * @var GetShoppingListDetailQuery
     */
    private GetShoppingListDetailQuery $query;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->query = new GetShoppingListDetailQuery(
            $this->repository = $this->createMock(ShoppingListRepositoryInterface::class),
        );
    }

    public function test(): void
    {
        $list = new ShoppingList(new Slug('my-groceries'), 'My Groceries', new ShoppingItemStack(
            new ShoppingItem(1, 'Apples', true),
            new ShoppingItem(2, 'Bananas', false),
        ));

        $this->repository
            ->expects($this->once())
            ->method('findOrFail')
            ->with('my-groceries')
            ->willReturn($list);

        $expected = new ShoppingListDetailModel('my-groceries', 'My Groceries', [
            new ShoppingItemDetailModel(1, 'Apples', true),
            new ShoppingItemDetailModel(2, 'Bananas', false),
        ]);

        $actual = $this->query->execute('my-groceries');

        $this->assertEquals($expected, $actual);
    }
}
