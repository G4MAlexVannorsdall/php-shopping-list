<?php

declare(strict_types=1);

namespace Lindyhopchris\ShoppingList\Application\Commands\ArchiveShoppingList;

use Lindyhopchris\ShoppingList\Persistance\ShoppingListRepositoryInterface;
use Lindyhopchris\ShoppingList\Application\Commands\ArchiveShoppingList\Validation\ArchiveShoppingListValidator;

class ArchiveShoppingListCommand implements ArchiveShoppingListCommandInterface
{
    /**
     * @var ShoppingListRepositoryInterface
     */
    private ShoppingListRepositoryInterface $repository;

    /**
     * @var ArchiveShoppingListValidator
     */
    private ArchiveShoppingListValidator $validator;

    /**
     * @param ShoppingListRepositoryInterface $repository
     * @param ArchiveShoppingListValidator $validator
     */
    public function __construct(ShoppingListRepositoryInterface $repository, ArchiveShoppingListValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    /**
     * @inheritDoc
     */
    public function execute(ArchiveShoppingListModel $model): void
    {
        $this->validator->validateOrFail($model);

        $list = $this->repository->findOrFail(
            $model->getList(),
        );

        $list->setArchived(true);

        $this->repository->store($list);
    }
}
