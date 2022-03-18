<?php
declare(strict_types=1);

namespace Tests\Unit\Persistence\Json;

use Lindyhopchris\ShoppingList\Domain\ShoppingItem;
use Lindyhopchris\ShoppingList\Domain\ShoppingItemStack;
use Lindyhopchris\ShoppingList\Persistance\Json\ShoppingItemFactory;
use PHPUnit\Framework\TestCase;

class ShoppingItemFactoryTest extends TestCase
{
    /**
     * @var ShoppingItemFactory
     */
    private ShoppingItemFactory $factory;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->factory = new ShoppingItemFactory();
    }

    public function testMake(): void
    {
        $expected = new ShoppingItem(1, 'Bananas', true);

        $actual = $this->factory->make([
            'id' => $expected->getId(),
            'name' => $expected->getName(),
            'completed' => $expected->isCompleted(),
        ]);

        $this->assertEquals($expected, $actual);
    }

    public function testMakeMany(): void
    {
        $expected = new ShoppingItemStack(
            $a = new ShoppingItem(1, 'Bananas', true),
            $b = new ShoppingItem(2, 'Apples', false),
        );

        $actual = $this->factory->makeMany([
            [
               'id' => $a->getId(),
               'name' => $a->getName(),
               'completed' => $a->isCompleted(),
            ],
            [
                'id' => $b->getId(),
                'name' => $b->getName(),
                'completed' => $b->isCompleted(),
            ],
        ]);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return array
     */
    public function keyProvider(): array
    {
        return [
            ['id'],
            ['name'],
            ['completed'],
        ];
    }

    /**
     * @param string $key
     * @dataProvider keyProvider
     */
    public function testMissingKey(string $key): void
    {
        $values = [
            'id' => 1,
            'name' => 'Bananas',
            'completed' => false,
        ];

        unset($values[$key]);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Invalid shopping item array');

        $this->factory->make($values);
    }
}
