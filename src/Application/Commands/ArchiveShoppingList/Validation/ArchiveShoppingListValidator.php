<?php

namespace Lindyhopchris\ShoppingList\Application\Commands\ArchiveShoppingList\Validation;

use Lindyhopchris\ShoppingList\Persistance\ShoppingListRepositoryInterface;

class ArchiveShoppingListValidator implements ArchiveShoppingListRuleInterface
{
    private shoppingListRepositoryInterface $repository;

    public function __construct(ShoppingListRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function
}
