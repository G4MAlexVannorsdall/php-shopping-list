<?php
declare(strict_types=1);

namespace Lindyhopchris\ShoppingList\Application\Commands\TickOffShoppingItem\Validation;

use Lindyhopchris\ShoppingList\Application\Commands\TickOffShoppingItem\TickOffShoppingItemModel;
use Lindyhopchris\ShoppingList\Common\Validation\ValidationMessageStack;

interface TickOffShoppingItemRuleInterface
{
    /**
     * Validate the tick-off shopping item model.
     *
     * @param TickOffShoppingItemModel $model
     * @return ValidationMessageStack
     */
    public function validate(TickOffShoppingItemModel $model): ValidationMessageStack;
}
