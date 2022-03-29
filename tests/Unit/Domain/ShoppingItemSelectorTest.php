<?php
declare(strict_types=1);

namespace Tests\Unit\Domain;

use Lindyhopchris\ShoppingList\Domain\ShoppingItem;
use Lindyhopchris\ShoppingList\Domain\ShoppingItemSelector;
use Lindyhopchris\ShoppingList\Domain\ShoppingItemStack;
use PHPUnit\Framework\TestCase;

class ShoppingItemSelectorTest extends TestCase
{
    /**
     * @var ShoppingItemStack
     */
    private ShoppingItemStack $items;

    /**
     * @var ShoppingItem
     */
    private ShoppingItem $bananas;

    /**
     * @var ShoppingItem
     */
    private ShoppingItem $pears;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->items = new ShoppingItemStack(
            new ShoppingItem(1, 'Apples', false),
            $this->bananas = new ShoppingItem(2, 'Bananas', true),
            $this->pears = new ShoppingItem(3, 'Pears', false),
        );
    }

    public function testItMatchesName(): void
    {
        $selector = new ShoppingItemSelector('Pears');

        $actual = $this->items->select($selector);

        $this->assertSame($this->pears, $actual);
    }

    public function testItMatchesCaseInsensitiveName(): void
    {
        $selector = new ShoppingItemSelector('pears');

        $actual = $this->items->select($selector);

        $this->assertSame($this->pears, $actual);
    }

    public function testItMatchesNameAndCompleted(): void
    {
        $selector = new ShoppingItemSelector('Pears', false);

        $actual = $this->items->select($selector);

        $this->assertSame($this->pears, $actual);
    }

    public function testItDoesNotMatchNameIfCompletedDoesNotMatch(): void
    {
        $selector = new ShoppingItemSelector('Pears', true);

        $actual = $this->items->select($selector);

        $this->assertNull($actual);
    }

    public function testItMatchesId(): void
    {
        $selector = new ShoppingItemSelector(2);

        $actual = $this->items->select($selector);

        $this->assertSame($this->bananas, $actual);
    }

    public function testItMatchesIdAndCompleted(): void
    {
        $selector = new ShoppingItemSelector(2, true);

        $actual = $this->items->select($selector);

        $this->assertSame($this->bananas, $actual);
    }

    public function testItDoesNotMatchIdIfCompletedDoesNotMatch(): void
    {
        $selector = new ShoppingItemSelector(2, false);

        $actual = $this->items->select($selector);

        $this->assertNull($actual);
    }
}
