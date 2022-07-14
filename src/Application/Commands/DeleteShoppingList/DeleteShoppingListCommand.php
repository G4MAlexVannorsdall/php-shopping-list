<?php

namespace Lindyhopchris\ShoppingList\Application\Commands\DeleteShoppingList;

use Lindyhopchris\ShoppingList\Persistance\ShoppingListRepositoryInterface;

class DeleteShoppingListCommand implements DeleteShoppingListCommandInterface
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
     * @param DeleteShoppingListModel $model
     */
    public function execute(DeleteShoppingListModel $model): void
    {
        $list = $this->repository->findOrFail(
            $model->getList(),
        );

        $this->repository->delete($list->getSlug());
    }
}
