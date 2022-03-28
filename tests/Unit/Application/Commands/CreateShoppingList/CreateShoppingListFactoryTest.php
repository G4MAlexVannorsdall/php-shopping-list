<?php
declare(strict_types=1);

namespace Tests\Unit\Application\Commands\CreateShoppingList;

use Lindyhopchris\ShoppingList\Application\Commands\CreateShoppingList\CreateShoppingListFactory;
use Lindyhopchris\ShoppingList\Domain\Slug;
use PHPUnit\Framework\TestCase;

class CreateShoppingListFactoryTest extends TestCase
{
    public function test(): void
    {
        $factory = new CreateShoppingListFactory();

        $actual = $factory->make('my-groceries', 'My Groceries');

        $this->assertEquals(new Slug('my-groceries'), $actual->getSlug());
        $this->assertSame('My Groceries', $actual->getName());
        $this->assertEmpty($actual->getItems());
    }
}
