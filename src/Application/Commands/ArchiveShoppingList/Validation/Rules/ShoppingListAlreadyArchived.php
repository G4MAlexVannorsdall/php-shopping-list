<?php

namespace Lindyhopchris\ShoppingList\Application\Commands\ArchiveShoppingList\Validation\Rules;

use Lindyhopchris\ShoppingList\Application\Commands\ArchiveShoppingList\ArchiveShoppingListModel;
use Lindyhopchris\ShoppingList\Application\Commands\ArchiveShoppingList\Validation\ArchiveShoppingListRuleInterface;
use Lindyhopchris\ShoppingList\Common\Validation\ValidationMessageStack;

class ShoppingListAlreadyArchived implements ArchiveShoppingListRuleInterface
{
    public function validate(ArchiveShoppingListModel $model): ValidationMessageStack
    {
        $result = new ValidationMessageStack();

        if ()
    }
}
