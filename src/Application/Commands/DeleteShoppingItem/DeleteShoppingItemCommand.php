<?php

namespace Lindyhopchris\ShoppingList\Application\Commands\DeleteShoppingItem;

use Lindyhopchris\ShoppingList\Domain\ShoppingItemSelector;
use Lindyhopchris\ShoppingList\Persistance\ShoppingListRepositoryInterface;

class DeleteShoppingItemCommand
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
     */
    public function execute(DeleteShoppingItemModel $model): void
    {
        $list = $this->repository->findOrFail(
            $model->getList()
        );

        $item = $list->getItems()->select(
            new ShoppingItemSelector($model->getItem())
        );

        $list->removeItem($item);

        $this->repository->store($list);
    }
}
