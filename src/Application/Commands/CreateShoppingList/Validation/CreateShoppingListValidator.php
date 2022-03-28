<?php
declare(strict_types=1);

namespace Lindyhopchris\ShoppingList\Application\Commands\CreateShoppingList\Validation;

use Lindyhopchris\ShoppingList\Application\Commands\CreateShoppingList\CreateShoppingListModel;
use Lindyhopchris\ShoppingList\Common\Validation\ValidationException;
use Lindyhopchris\ShoppingList\Common\Validation\ValidationMessageStack;

class CreateShoppingListValidator
{
    /**
     * @var CreateShoppingListRuleInterface[]
     */
    private array $rules;

    /**
     * CreateShoppingListValidator constructor.
     *
     * @param CreateShoppingListRuleInterface ...$rules
     */
    public function __construct(CreateShoppingListRuleInterface ...$rules)
    {
        $this->rules = $rules;
    }

    /**
     * Validate the provided model.
     *
     * @param CreateShoppingListModel $model
     * @return ValidationMessageStack
     */
    public function validate(CreateShoppingListModel $model): ValidationMessageStack
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
     * @param CreateShoppingListModel $model
     * @return void
     * @throws ValidationException
     */
    public function validateOrFail(CreateShoppingListModel $model): void
    {
        $result = $this->validate($model);

        if ($result->hasErrors()) {
            throw new ValidationException($result, 'Invalid shopping list.');
        }
    }
}
