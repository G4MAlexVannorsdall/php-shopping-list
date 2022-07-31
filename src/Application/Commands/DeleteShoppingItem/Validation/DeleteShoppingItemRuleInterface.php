<?php

namespace Lindyhopchris\ShoppingList\Application\Commands\DeleteShoppingItem\Validation;

use Lindyhopchris\ShoppingList\Application\Commands\DeleteShoppingItem\DeleteShoppingItemModel;
use Lindyhopchris\ShoppingList\Common\Validation\ValidationMessageStack;

interface DeleteShoppingItemRuleInterface
{
    /**
     * Validate the delete shopping item model.
     *
     * @param DeleteShoppingItemModel $model
     * @return ValidationMessageStack
     */
    public function validate(DeleteShoppingItemModel $model): ValidationMessageStack;
}
