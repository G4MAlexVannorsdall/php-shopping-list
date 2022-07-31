<?php

namespace Lindyhopchris\ShoppingList\Application\Commands\DeleteShoppingItem;

use Lindyhopchris\ShoppingList\Application\Commands\DeleteShoppingItem\Validation\DeleteShoppingItemValidator;
use Lindyhopchris\ShoppingList\Common\Validation\ValidationException;
use Lindyhopchris\ShoppingList\Common\Validation\ValidationMessageStack;
use Lindyhopchris\ShoppingList\Domain\ShoppingItemSelector;
use Lindyhopchris\ShoppingList\Persistance\ShoppingListRepositoryInterface;

class DeleteShoppingItemCommand
{
    /**
     * @var ShoppingListRepositoryInterface
     */
    private ShoppingListRepositoryInterface $repository;

    /**
     * @var DeleteShoppingItemValidator
     */
    private DeleteShoppingItemValidator $validator;

    /**
     * @param ShoppingListRepositoryInterface $repository
     * @param DeleteShoppingItemValidator $validator
     */
    public function __construct(ShoppingListRepositoryInterface $repository, DeleteShoppingItemValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    /**
     * @param DeleteShoppingItemModel $model
     */
    public function execute(DeleteShoppingItemModel $model): void
    {
        $this->validator->validateOrFail($model);

        $list = $this->repository->findOrFail(
            $model->getList()
        );

        $item = $list->getItems()->select(
            new ShoppingItemSelector($model->getItem())
        );

        if ($item === null) {
            throw new ValidationException(new ValidationMessageStack(['Shopping item does not exist or has already been deleted.']));
        }
        $list->removeItem($item);

        $this->repository->store($list);
    }
}
