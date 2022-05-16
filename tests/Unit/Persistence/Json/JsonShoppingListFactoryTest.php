<?php
declare(strict_types=1);

namespace Tests\Unit\Persistence\Json;

use Lindyhopchris\ShoppingList\Domain\ShoppingItem;
use Lindyhopchris\ShoppingList\Domain\ShoppingItemStack;
use Lindyhopchris\ShoppingList\Domain\ShoppingList;
use Lindyhopchris\ShoppingList\Domain\ValueObjects\Slug;
use Lindyhopchris\ShoppingList\Persistance\Json\JsonShoppingItemFactory;
use Lindyhopchris\ShoppingList\Persistance\Json\JsonShoppingListFactory;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class JsonShoppingListFactoryTest extends TestCase
{

    /**
     * @var JsonShoppingListFactory
     */
    private JsonShoppingListFactory $factory;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->factory = new JsonShoppingListFactory(new JsonShoppingItemFactory());
    }

    /**
     * @return array
     */
    public function test(): array
    {
        $values = [
            'slug' => 'my-list',
            'name' => 'My List',
            'items' => [
                [
                    'id' => 1,
                    'name' => 'Bananas',
                    'completed' => true,
                ],
            ],
        ];

        $expected = new ShoppingList(
            new Slug('my-list'),
            'My List',
            new ShoppingItemStack(new ShoppingItem(
                $values['items'][0]['id'],
                $values['items'][0]['name'],
                $values['items'][0]['completed'],
            )),
        );

        $actual = $this->factory->make($values);

        $this->assertEquals($expected, $actual);

        return $values;
    }

    /**
     * @return array
     */
    public function keyProvider(): array
    {
        return [
            ['slug'],
            ['name'],
            ['items'],
        ];
    }

    /**
     * @param string $key
     * @param array $values
     * @depends test
     * @dataProvider keyProvider
     */
    public function testMissingKey(string $key, array $values): void
    {
        unset($values[$key]);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Invalid shopping list array');

        $this->factory->make($values);
    }
}
