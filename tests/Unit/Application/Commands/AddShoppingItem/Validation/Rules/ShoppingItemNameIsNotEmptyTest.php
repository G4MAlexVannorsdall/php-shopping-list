<?php
declare(strict_types=1);

namespace Tests\Unit\Application\Commands\AddShoppingItem\Validation\Rules;

use Lindyhopchris\ShoppingList\Application\Commands\AddShoppingItem\AddShoppingItemModel;
use Lindyhopchris\ShoppingList\Application\Commands\AddShoppingItem\Validation\Rules\ShoppingItemNameIsNotEmpty;
use PHPUnit\Framework\TestCase;

class ShoppingItemNameIsNotEmptyTest extends TestCase
{
    /**
     * @var ShoppingItemNameIsNotEmpty
     */
    private ShoppingItemNameIsNotEmpty $rule;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->rule = new ShoppingItemNameIsNotEmpty();
    }

    public function testValid(): void
    {
        $model = new AddShoppingItemModel('my-groceries', 'Bananas');

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
        $model = new AddShoppingItemModel('my-groceries', $value);

        $actual = $this->rule->validate($model);

        $this->assertTrue($actual->hasErrors());
        $this->assertSame(['Shopping item name cannot be empty.'], $actual->getMessages());
    }
}
