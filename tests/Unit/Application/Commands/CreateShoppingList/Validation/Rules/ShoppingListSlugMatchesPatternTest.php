<?php
declare(strict_types=1);

namespace Tests\Unit\Application\Commands\CreateShoppingList\Validation\Rules;

use Lindyhopchris\ShoppingList\Application\Commands\CreateShoppingList\CreateShoppingListModel;
use Lindyhopchris\ShoppingList\Application\Commands\CreateShoppingList\Validation\Rules\ShoppingListSlugMatchesPattern;
use PHPUnit\Framework\TestCase;

class ShoppingListSlugMatchesPatternTest extends TestCase
{
    /**
     * @var ShoppingListSlugMatchesPattern
     */
    private ShoppingListSlugMatchesPattern $rule;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->rule = new ShoppingListSlugMatchesPattern();
    }

    public function testValid(): void
    {
        $model = new CreateShoppingListModel('my-groceries', 'My Groceries');

        $actual = $this->rule->validate($model);

        $this->assertFalse($actual->hasErrors());
    }

    public function testInvalid(): void
    {
        $model = new CreateShoppingListModel('1', 'My Groceries');

        $actual = $this->rule->validate($model);

        $this->assertTrue($actual->hasErrors());
        $this->assertSame(['The slug format is invalid.'], $actual->getMessages());
    }
}
