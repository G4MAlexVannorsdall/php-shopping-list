<?php

namespace Lindyhopchris\ShoppingList\Application\Commands\ArchiveShoppingList\Validation\Rules;

use Lindyhopchris\ShoppingList\Application\Commands\ArchiveShoppingList\ArchiveShoppingListModel;
use Lindyhopchris\ShoppingList\Application\Commands\ArchiveShoppingList\Validation\ArchiveShoppingListRuleInterface;
use Lindyhopchris\ShoppingList\Persistance\ShoppingListRepositoryInterface;
use Lindyhopchris\ShoppingList\Common\Validation\ValidationMessageStack;

class ShoppingListSlugDoesNotExist implements ArchiveShoppingListRuleInterface
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
     * @param ArchiveShoppingListModel $model
     * @return ValidationMessageStack
     */
    public function validate(ArchiveShoppingListModel $model): ValidationMessageStack
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
