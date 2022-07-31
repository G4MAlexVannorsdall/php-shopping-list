<?php

namespace Lindyhopchris\ShoppingList\Application\Commands\DeleteShoppingItem\Validation\Rules;

use Lindyhopchris\ShoppingList\Application\Commands\DeleteShoppingItem\DeleteShoppingItemModel;
use Lindyhopchris\ShoppingList\Application\Commands\DeleteShoppingItem\Validation\DeleteShoppingItemRuleInterface;
use Lindyhopchris\ShoppingList\Common\Validation\ValidationMessageStack;
use Lindyhopchris\ShoppingList\Domain\ShoppingItemSelector;
use Lindyhopchris\ShoppingList\Persistance\ShoppingListRepositoryInterface;

class ShoppingItemAlreadyDeleted implements DeleteShoppingItemRuleInterface
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

        $list = $this->repository->find(
            $model->getList(),
        );

        $item = $list->getItems()->select(
            new ShoppingItemSelector($model->getItem(), false),
        );

        if (null === $item) {
            $result->addMessage(sprintf(
                'Shopping item "%s" does not exist or has already been deleted.',
                $model->getItem(),
            ));
        }

        return $result;
    }
}
