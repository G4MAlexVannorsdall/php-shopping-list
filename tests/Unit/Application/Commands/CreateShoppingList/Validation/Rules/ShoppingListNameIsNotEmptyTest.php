<?php
declare(strict_types=1);

namespace Tests\Unit\Application\Commands\CreateShoppingList\Validation\Rules;

use Lindyhopchris\ShoppingList\Application\Commands\CreateShoppingList\CreateShoppingListModel;
use Lindyhopchris\ShoppingList\Application\Commands\CreateShoppingList\Validation\Rules\ShoppingListNameIsNotEmpty;
use PHPUnit\Framework\TestCase;

class ShoppingListNameIsNotEmptyTest extends TestCase
{
    /**
     * @var ShoppingListNameIsNotEmpty
     */
    private ShoppingListNameIsNotEmpty $rule;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->rule = new ShoppingListNameIsNotEmpty();
    }

    public function testValid(): void
    {
        $model = new CreateShoppingListModel('my-groceries', 'My Groceries');

        $actual = $this->rule->validate($model)->hasErrors();

        $this->assertFalse($actual);
    }

    /**
     * @return array
     */
    public function invalidProvider(): array
    {
        return [
            [''],
            ['  '],
        ];
    }

    /**
     * @param string $value
     * @return void
     * @dataProvider invalidProvider
     */
    public function testInvalid(string $value): void
    {
        $model = new CreateShoppingListModel('my-groceries', $value);

        $actual = $this->rule->validate($model);

        $this->assertTrue($actual->hasErrors());
        $this->assertSame(['Shopping list name cannot be empty.'], $actual->getMessages());
    }
}
