<?php
declare(strict_types=1);

namespace Tests\Unit\Persistence\Json;

use Lindyhopchris\ShoppingList\Domain\ShoppingList;
use Lindyhopchris\ShoppingList\Domain\Slug;
use Lindyhopchris\ShoppingList\Persistance\Json\JsonFileHandler;
use Lindyhopchris\ShoppingList\Persistance\Json\JsonShoppingList;
use Lindyhopchris\ShoppingList\Persistance\Json\JsonShoppingListRepository;
use Lindyhopchris\ShoppingList\Persistance\Json\ShoppingListFactory;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class JsonShoppingListRepositoryTest extends TestCase
{
    /**
     * @var MockObject|JsonFileHandler|mixed
     */
    private MockObject $files;

    /**
     * @var MockObject|ShoppingListFactory|mixed
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
            $this->factory = $this->createMock(ShoppingListFactory::class)
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

    public function testListDoesNotExist(): void
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

    public function testListDoesExist(): void
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

    public function testStore(): void
    {
        $list = new ShoppingList(new Slug('my-list'), 'My List');

        $this->files
            ->expects($this->once())
            ->method('write')
            ->with('my-list.json', $this->equalTo(new JsonShoppingList($list)));

        $this->repository->store($list);
    }
}
