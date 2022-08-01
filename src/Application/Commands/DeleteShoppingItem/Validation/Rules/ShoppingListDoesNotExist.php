<?php

namespace Lindyhopchris\ShoppingList\Application\Commands\DeleteShoppingItem\Validation\Rules;

use Lindyhopchris\ShoppingList\Application\Commands\DeleteShoppingItem\DeleteShoppingItemModel;
use Lindyhopchris\ShoppingList\Application\Commands\DeleteShoppingItem\Validation\DeleteShoppingItemRuleInterface;
use Lindyhopchris\ShoppingList\Common\Validation\ValidationMessageStack;
use Lindyhopchris\ShoppingList\Persistance\ShoppingListRepositoryInterface;

class ShoppingListDoesNotExist implements DeleteShoppingItemRuleInterface
{
    /**
     * @var ShoppingListRepositoryInterface
     */
    private ShoppingListRepositoryInterface $repository;

    /**
     * @param ShoppingListRepositoryInterface $repository
     */
    public function __construct(ShoppingListRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param DeleteShoppingItemModel $model
     * @return ValidationMessageStack
     */
    public function validate(DeleteShoppingItemModel $model): ValidationMessageStack
    {
        $result = new ValidationMessageStack();

        if (!$this->repository->exists($model->getList())) {
            $result->addMessage(sprintf('Shopping list "%s" does not exist.',
                $model->getList(),
            ));
        }
        return $result;
    }
}
