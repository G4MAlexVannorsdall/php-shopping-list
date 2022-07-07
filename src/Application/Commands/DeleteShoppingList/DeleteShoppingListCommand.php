<?php

namespace Lindyhopchris\ShoppingList\Application\Commands\DeleteShoppingList;

use Lindyhopchris\ShoppingList\Domain\ShoppingList;
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
        // Get the list
        $list = $this->repository->findOrFail(
            $model->getList(),
        );

        // Get the slug of the list
        $slug = $list->getSlug();

        // Then unlink/delete that list with the given slug
       $this->repository->unlink($slug); // Work in progress
    }
}
