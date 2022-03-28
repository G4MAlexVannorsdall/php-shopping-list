<?php
declare(strict_types=1);

namespace Lindyhopchris\ShoppingList\Application\Commands\AddShoppingItem\Validation;

use Lindyhopchris\ShoppingList\Application\Commands\AddShoppingItem\AddShoppingItemModel;
use Lindyhopchris\ShoppingList\Common\Validation\ValidationException;
use Lindyhopchris\ShoppingList\Common\Validation\ValidationMessageStack;

class AddShoppingItemValidator
{
    /**
     * @var AddShoppingItemRuleInterface[]
     */
    private array $rules;

    /**
     * AddShoppingItemValidator constructor.
     *
     * @param AddShoppingItemRuleInterface ...$rules
     */
    public function __construct(AddShoppingItemRuleInterface ...$rules)
    {
        $this->rules = $rules;
    }

    /**
     * Validate the provided add shopping item model.
     *
     * @param AddShoppingItemModel $model
     * @return ValidationMessageStack
     */
    public function validate(AddShoppingItemModel $model): ValidationMessageStack
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
     * @param AddShoppingItemModel $model
     * @return void
     * @throws ValidationException
     */
    public function validateOrFail(AddShoppingItemModel $model): void
    {
        $result = $this->validate($model);

        if ($result->hasErrors()) {
            throw new ValidationException($result, 'Invalid shopping item.');
        }
    }
}
