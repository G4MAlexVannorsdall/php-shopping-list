<?php
declare(strict_types=1);

namespace Tests\Unit\Domain;

use Lindyhopchris\ShoppingList\Domain\ShoppingItem;
use Lindyhopchris\ShoppingList\Domain\ShoppingItemStack;
use Lindyhopchris\ShoppingList\Domain\ShoppingList;
use PHPUnit\Framework\TestCase;

class ShoppingListTest extends TestCase
{
    public function testConstructWithoutList(): ShoppingList
    {
        $list = new ShoppingList('my-list', 'My List');

        $this->assertSame('my-list', $list->getSlug());
        $this->assertSame('My List', $list->getName());
        $this->assertEmpty($list->getItems()->all());

        return $list;
    }

    public function testConstructWithList(): void
    {
        $list = new ShoppingList(
            'my-list',
            'My List',
            $expected = new ShoppingItemStack(new ShoppingItem(1, 'Bananas')),
        );

        $this->assertSame($expected, $list->getItems());
    }

    /**
     * @param ShoppingList $list
     * @depends testConstructWithoutList
     */
    public function testSetName(ShoppingList $list): void
    {
        $this->assertSame($list, $list->setName('My Other List'));
        $this->assertSame('My Other List', $list->getName());
    }

    /**
     * @return array
     */
    public function invalidSlugProvider(): array
    {
        return [
            ['MY-LIST'],
        ];
    }

    /**
     * @param string $value
     * @dataProvider invalidSlugProvider
     */
    public function testInvalidSlug(string $value): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('slug');

        new ShoppingList($value, 'My List');
    }
}
