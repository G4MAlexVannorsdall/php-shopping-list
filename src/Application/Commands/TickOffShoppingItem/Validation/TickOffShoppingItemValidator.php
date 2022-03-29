<?php
declare(strict_types=1);

namespace Lindyhopchris\ShoppingList\Application\Commands\TickOffShoppingItem\Validation;

use Lindyhopchris\ShoppingList\Application\Commands\TickOffShoppingItem\TickOffShoppingItemModel;
use Lindyhopchris\ShoppingList\Common\Validation\ValidationException;
use Lindyhopchris\ShoppingList\Common\Validation\ValidationMessageStack;

class TickOffShoppingItemValidator
{
    /**
     * @var TickOffShoppingItemRuleInterface[]
     */
    private array $rules;

    /**
     * TickOffShoppingItemValidator constructor.
     *
     * @param TickOffShoppingItemRuleInterface ...$rules
     */
    public function __construct(TickOffShoppingItemRuleInterface ...$rules)
    {
        $this->rules = $rules;
    }

    /**
     * Validate the provided add shopping item model.
     *
     * @param TickOffShoppingItemModel $model
     * @return ValidationMessageStack
     */
    public function validate(TickOffShoppingItemModel $model): ValidationMessageStack
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
     * @param TickOffShoppingItemModel $model
     * @return void
     * @throws ValidationException
     */
    public function validateOrFail(TickOffShoppingItemModel $model): void
    {
        $result = $this->validate($model);

        if ($result->hasErrors()) {
            throw new ValidationException($result, 'Invalid shopping item to tick off.');
        }
    }
}
