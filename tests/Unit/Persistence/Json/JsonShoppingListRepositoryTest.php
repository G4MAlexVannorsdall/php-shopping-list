<?php
declare(strict_types=1);

namespace Tests\Unit\Persistence\Json;

use Lindyhopchris\ShoppingList\Domain\ShoppingList;
use Lindyhopchris\ShoppingList\Domain\ValueObjects\Slug;
use Lindyhopchris\ShoppingList\Persistance\Json\JsonFileHandler;
use Lindyhopchris\ShoppingList\Persistance\Json\JsonShoppingList;
use Lindyhopchris\ShoppingList\Persistance\Json\JsonShoppingListRepository;
use Lindyhopchris\ShoppingList\Persistance\Json\JsonShoppingListFactory;
use Lindyhopchris\ShoppingList\Persistance\ShoppingListNotFoundException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class JsonShoppingListRepositoryTest extends TestCase
{
    /**
     * @var MockObject|JsonFileHandler|mixed
     */
    private MockObject $files;

    /**
     * @var MockObject|JsonShoppingListFactory|mixed
     */
    private MockObject $factory;

    /**
     * @var JsonShoppingListRepository
     */
    private JsonShoppingListRepository $repository;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = new JsonShoppingListRepository(
            $this->files = $this->createMock(JsonFileHandler::class),
            $this->factory = $this->createMock(JsonShoppingListFactory::class)
        );
    }

    public function testExists(): void
    {
        $this->files
            ->expects($this->exactly(2))
            ->method('exists')
            ->with('my-list.json')
            ->willReturnOnConsecutiveCalls(false, true);

        $this->assertFalse($this->repository->exists('my-list'));
        $this->assertTrue($this->repository->exists('my-list'));
    }

    public function testFindListThatDoesNotExist(): void
    {
        $this->files
            ->expects($this->once())
            ->method('exists')
            ->with('my-list.json')
            ->willReturn(false);

        $this->factory
            ->expects($this->never())
            ->method($this->anything());

        $actual = $this->repository->find('my-list');

        $this->assertNull($actual);
    }

    public function testFindListDoesExist(): void
    {
        $expected = new ShoppingList(new Slug('my-list'), 'My List');

        $this->files
            ->expects($this->once())
            ->method('exists')
            ->with('my-list.json')
            ->willReturn(true);

        $this->files
            ->expects($this->once())
            ->method('decode')
            ->with('my-list.json')
            ->willReturn($json = ['foo' => 'bar']);

        $this->factory
            ->expects($this->once())
            ->method('make')
            ->with($json)
            ->willReturn($expected);

        $actual = $this->repository->find('my-list');

        $this->assertSame($expected, $actual);
    }

    public function testFindOrFailListThatDoesNotExist(): void
    {
        $this->files
            ->expects($this->once())
            ->method('exists')
            ->with('my-list.json')
            ->willReturn(false);

        $this->factory
            ->expects($this->never())
            ->method($this->anything());

        $this->expectException(ShoppingListNotFoundException::class);
        $this->expectExceptionMessage('my-list');

        $this->repository->findOrFail('my-list');
    }

    public function testFindOrFailListDoesExist(): void
    {
        $expected = new ShoppingList(new Slug('my-list'), 'My List');

        $this->files
            ->expects($this->once())
            ->method('exists')
            ->with('my-list.json')
            ->willReturn(true);

        $this->files
            ->expects($this->once())
            ->method('decode')
            ->with('my-list.json')
            ->willReturn($json = ['foo' => 'bar']);

        $this->factory
            ->expects($this->once())
            ->method('make')
            ->with($json)
            ->willReturn($expected);

        $actual = $this->repository->findOrFail('my-list');

        $this->assertSame($expected, $actual);
    }

    public function testStore(): void
    {
        $list = new ShoppingList(new Slug('my-list'), 'My List');

        $this->files
            ->expects($this->once())
            ->method('write')
            ->with('my-list.json', $this->equalTo(new JsonShoppingList($list)));

        $this->repository->store($list);
    }

    public function testDeleteAListThatDoesExist(): void
    {
        // Arrange: Given a shopping list
        // Act: We expect the list to be called on once, using the delete method with the list
        $this->files
            ->expects($this->once())
            ->method('exists')
            ->with('supplies.json')
            ->willReturn(true);

        $this->files
            ->expects($this->once())
            ->method('unlink')
            ->with('supplies.json');

        // Assert: That the list has been deleted
        $this->repository->delete('supplies');
    }

    public function testDeleteAListThatDoesNotExist(): void
    {
        // Arrange: Given a shopping list does not exist
        // Act: When the list is deleted via the repo

        $this->files
            ->expects($this->once())
            ->method('exists')
            ->with('supplies.json')
            ->willReturn(false);

        $this->files
            ->expects($this->never())
            ->method('unlink');

        // Assert: Then an exception is thrown saying the list does not exist
        $this->expectException(ShoppingListNotFoundException::class);

        $this->repository->delete('supplies');
    }
}
