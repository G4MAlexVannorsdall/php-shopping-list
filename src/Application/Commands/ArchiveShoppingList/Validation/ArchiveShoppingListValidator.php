<?php

namespace Lindyhopchris\ShoppingList\Application\Commands\ArchiveShoppingList\Validation;



use Lindyhopchris\ShoppingList\Application\Commands\ArchiveShoppingList\ArchiveShoppingListModel;
use Lindyhopchris\ShoppingList\Common\Validation\ValidationException;
use Lindyhopchris\ShoppingList\Common\Validation\ValidationMessageStack;

class ArchiveShoppingListValidator
{
    /**
     * @var ArchiveShoppingListRuleInterface[]
     */
    private array $rules;

    /**
     * @param ArchiveShoppingListRuleInterface ...$rules
     */
    public function __construct(ArchiveShoppingListRuleInterface...$rules)
    {
        $this->rules = $rules;
    }

    /**
     * Validate the provided shopping list model.
     *
     * @param ArchiveShoppingListModel $model
     * @return ValidationMessageStack
     */
    public function validate(ArchiveShoppingListModel $model): ValidationMessageStack
    {
        $result = new ValidationMessageStack();

        foreach ($this->rules as $rule) {
            $result->merge($rule->validate($model));
        }

        return $result;
    }

    /**
     * Validate the provided model and throw an exception if it is invalid.
     *
     * @param ArchiveShoppingListModel $model
     */
    public function validateOrFail(ArchiveShoppingListModel $model): void
    {
        $result = $this->validate($model);

        if ($result->hasErrors()) {
            throw new ValidationException($result, 'Invalid shopping list to archive.');
        }
    }
}
