<?php
declare(strict_types=1);

namespace Lindyhopchris\ShoppingList\Application\Commands\CreateShoppingList\Validation;

use Lindyhopchris\ShoppingList\Application\Commands\CreateShoppingList\CreateShoppingListModel;
use Lindyhopchris\ShoppingList\Common\Validation\ValidationMessageStack;

interface CreateShoppingListRuleInterface
{
    /**
     * Validate the provided create shopping list model.
     *
     * @param CreateShoppingListModel $model
     * @return ValidationMessageStack
     */
    public function validate(CreateShoppingListModel $model): ValidationMessageStack;
}
