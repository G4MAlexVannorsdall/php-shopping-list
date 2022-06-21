<?php

namespace Lindyhopchris\ShoppingList\Application\Commands\ArchiveShoppingList\Validation\Rules;

use Lindyhopchris\ShoppingList\Application\Commands\ArchiveShoppingList\ArchiveShoppingListModel;
use Lindyhopchris\ShoppingList\Application\Commands\ArchiveShoppingList\Validation\ArchiveShoppingListRuleInterface;
use Lindyhopchris\ShoppingList\Common\Validation\ValidationMessageStack;
use Lindyhopchris\ShoppingList\Domain\ShoppingList;
use Lindyhopchris\ShoppingList\Persistance\ShoppingListRepositoryInterface;

class ShoppingListAlreadyArchived implements ArchiveShoppingListRuleInterface
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

        $list = $this->repository->find(
            $model->getList(),
        );

        if (null === $list) {
           return $result;
        }
        elseif (true === $list->isArchived()) {
            $result->addMessage(sprintf(
                'Shopping list "%s" is already archived.',
                $model->getList(),
            ));
        }
        return $result;
    }
}
