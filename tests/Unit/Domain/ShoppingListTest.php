<?php
declare(strict_types=1);

namespace Tests\Unit\Domain;

use Lindyhopchris\ShoppingList\Domain\ShoppingItem;
use Lindyhopchris\ShoppingList\Domain\ShoppingItemStack;
use Lindyhopchris\ShoppingList\Domain\ShoppingList;
use Lindyhopchris\ShoppingList\Domain\ValueObjects\Slug;
use PHPUnit\Framework\TestCase;

class ShoppingListTest extends TestCase
{
    public function testConstructWithoutList(): ShoppingList
    {
        $list = new ShoppingList(
            $slug = new Slug('my-list'),
            'My List',
        );

        $this->assertSame($slug, $list->getSlug());
        $this->assertSame('My List', $list->getName());
        $this->assertEmpty($list->getItems()->all());
        $this->assertFalse($list->isArchived());

        return $list;
    }

    public function testConstructWithList(): void
    {
        $list = new ShoppingList(
            new Slug('my-list'),
            'My List',
            false,
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

    public function testAddItem(): void
    {
        $item1 = new ShoppingItem(1, 'Bananas');
        $item2 = new ShoppingItem(2, 'Apples');

        $list = new ShoppingList(
            new Slug('my-groceries'),
            'My Groceries',
            false,
            new ShoppingItemStack($item1)
        );

        $list->addItem($item2);

        $this->assertSame([$item1, $item2], $list->getItems()->all());
    }

    public function testRemoveItem(): void
    {
        // Given a shopping list with three items
        $item1 = new ShoppingItem(1, 'Bananas');
        $item2 = new ShoppingItem(2, 'Apples');
        $item3 = new ShoppingItem(3, 'Pears', true);
        $item4 = new ShoppingItem(4, 'Apricots');

        $list = new ShoppingList(
            new Slug('my-groceries'),
            'My Groceries',
            false,
            new ShoppingItemStack($item1, $item2, $item3, $item4),
        );

        $expected = [
            new ShoppingItem(1, 'Bananas'),
            new ShoppingItem(2, 'Pears', true),
            new ShoppingItem(3, 'Apricots'),
        ];

        // When the second item is removed
        $list->removeItem($item2);

        // Then the shopping list now only has items 1, 3 and 4 in the list of items, and they are renumbered.
        $this->assertEquals($expected, $list->getItems()->all());
    }

    /**
     * @param ShoppingList $list
     * @depends testConstructWithoutList
     */
    public function testSetArchivedToTrue(ShoppingList $list): void
    {
        $this->assertSame(false, $list->isArchived());
        $this->assertSame($list, $list->setArchived(true));
        $this->assertTrue($list->isArchived());
    }

    public function testSetArchivedToFalse(): void
    {
        // Given: Given a list that is archived.
         $list = new ShoppingList(new Slug( 'my-supplies'),'My Supplies', true );
        // When: Set archived to false.
        $list->setArchived(false);
        // Then: The list is not archived.
        $this->assertFalse($list->isArchived());
    }
}

