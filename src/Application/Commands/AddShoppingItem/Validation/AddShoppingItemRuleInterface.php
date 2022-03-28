<?php
declare(strict_types=1);

namespace Lindyhopchris\ShoppingList\Application\Commands\AddShoppingItem\Validation;

use Lindyhopchris\ShoppingList\Application\Commands\AddShoppingItem\AddShoppingItemModel;
use Lindyhopchris\ShoppingList\Common\Validation\ValidationMessageStack;

interface AddShoppingItemRuleInterface
{
    /**
     * Validate the provided add shopping item model.
     *
     * @param AddShoppingItemModel $model
     * @return ValidationMessageStack
     */
    public function validate(AddShoppingItemModel $model): ValidationMessageStack;
}
