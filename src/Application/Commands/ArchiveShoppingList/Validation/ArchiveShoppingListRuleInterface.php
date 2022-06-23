<?php

namespace Lindyhopchris\ShoppingList\Application\Commands\ArchiveShoppingList\Validation;

use Lindyhopchris\ShoppingList\Application\Commands\ArchiveShoppingList\ArchiveShoppingListModel;
use Lindyhopchris\ShoppingList\Common\Validation\ValidationMessageStack;

interface ArchiveShoppingListRuleInterface
{
    /**
     * Validate the archived shopping list model.
     *
     * @param ArchiveShoppingListModel $model
     * @return ValidationMessageStack
     */
    public function validate(ArchiveShoppingListModel $model): ValidationMessageStack;
}
