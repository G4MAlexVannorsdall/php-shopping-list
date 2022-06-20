<?php

namespace Tests\Unit\Application\Commands\ArchiveShoppingList\Validation\Rules;

use Lindyhopchris\ShoppingList\Application\Commands\ArchiveShoppingList\ArchiveShoppingListModel;
use Lindyhopchris\ShoppingList\Application\Commands\ArchiveShoppingList\Validation\Rules\ShoppingListSlugDoesNotExist;
use PHPUnit\Framework\TestCase;

class ShoppingListSlugDoesNotExistTest extends TestCase
{

    /**
     * @var ShoppingListSlugDoesNotExist
     */
    private ShoppingListSlugDoesNotExist $rule;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->rule = new ShoppingListSlugDoesNotExist();
    }

    public function testValid(): void
    {
        $model = new ArchiveShoppingListModel('supplies');

        $actual = $this->rule->validate($model)->hasErrors();

        $this->assertFalse($actual);
    }

    public function testInvalid(): void
    {

    }
}
