<?php

namespace Lindyhopchris\ShoppingList\Application\Commands\DeleteShoppingItem\Validation;

use Lindyhopchris\ShoppingList\Application\Commands\DeleteShoppingItem\DeleteShoppingItemModel;
use Lindyhopchris\ShoppingList\Common\Validation\ValidationException;
use Lindyhopchris\ShoppingList\Common\Validation\ValidationMessageStack;

class DeleteShoppingItemValidator
{
    /**
     * @var DeleteShoppingItemRuleInterface[]
     */
    private array $rules;

    /**
     * @param DeleteShoppingItemRuleInterface ...$rules
     */
    public function __construct(DeleteShoppingItemRuleInterface ...$rules)
    {
        $this->rules = $rules;
    }

    /**
     * Validate the provided delete shopping item model.
     *
     * @param DeleteShoppingItemModel $model
     * @return ValidationMessageStack
     */
    public function validate(DeleteShoppingItemModel $model): ValidationMessageStack
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
     * @param DeleteShoppingItemModel $model
     * @return void
     * @throws ValidationException
     */
    public function validateOrFail(DeleteShoppingItemModel $model): void
    {
        $result = $this->validate($model);

        if ($result->hasErrors()) {
            throw new ValidationException($result, 'Invalid shopping item to delete.');
        }
    }
}
