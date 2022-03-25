<?php
declare(strict_types=1);

namespace Lindyhopchris\ShoppingList\Application\Commands\CreateShoppingList\Validation\Rules;

use Lindyhopchris\ShoppingList\Application\Commands\CreateShoppingList\CreateShoppingListModel;
use Lindyhopchris\ShoppingList\Application\Commands\CreateShoppingList\Validation\CreateShoppingListRuleInterface;
use Lindyhopchris\ShoppingList\Common\Validation\ValidationMessageStack;

class ShoppingListNameIsNotEmpty implements CreateShoppingListRuleInterface
{
    /**
     * @inheritDoc
     */
    public function validate(CreateShoppingListModel $model): ValidationMessageStack
    {
        $result = new ValidationMessageStack();

        if (empty(trim($model->getName()))) {
            $result->addMessage('Shopping list name cannot be empty.');
        }

        return $result;
    }
}
