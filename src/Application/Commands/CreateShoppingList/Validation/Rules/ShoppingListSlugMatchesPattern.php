<?php
declare(strict_types=1);

namespace Lindyhopchris\ShoppingList\Application\Commands\CreateShoppingList\Validation\Rules;

use Lindyhopchris\ShoppingList\Application\Commands\CreateShoppingList\CreateShoppingListModel;
use Lindyhopchris\ShoppingList\Application\Commands\CreateShoppingList\Validation\CreateShoppingListRuleInterface;
use Lindyhopchris\ShoppingList\Common\Validation\ValidationMessageStack;
use Lindyhopchris\ShoppingList\Domain\Slug;

class ShoppingListSlugMatchesPattern implements CreateShoppingListRuleInterface
{
    /**
     * @inheritDoc
     */
    public function validate(CreateShoppingListModel $model): ValidationMessageStack
    {
        $result = new ValidationMessageStack();

        if (false === Slug::isValid($model->getSlug())) {
            $result->addMessage('The slug format is invalid.');
        }

        return $result;
    }
}
