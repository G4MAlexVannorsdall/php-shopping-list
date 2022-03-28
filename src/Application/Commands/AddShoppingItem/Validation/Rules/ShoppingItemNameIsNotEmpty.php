<?php
declare(strict_types=1);

namespace Lindyhopchris\ShoppingList\Application\Commands\AddShoppingItem\Validation\Rules;

use Lindyhopchris\ShoppingList\Application\Commands\AddShoppingItem\AddShoppingItemModel;
use Lindyhopchris\ShoppingList\Application\Commands\AddShoppingItem\Validation\AddShoppingItemRuleInterface;
use Lindyhopchris\ShoppingList\Common\Validation\ValidationMessageStack;

class ShoppingItemNameIsNotEmpty implements AddShoppingItemRuleInterface
{
    /**
     * @inheritDoc
     */
    public function validate(AddShoppingItemModel $model): ValidationMessageStack
    {
        $result = new ValidationMessageStack();

        if (empty(trim($model->getName()))) {
            $result->addMessage('Shopping item name cannot be empty.');
        }

        return $result;
    }
}
