<?php

declare(strict_types=1);

namespace Lindyhopchris\ShoppingList\Application\Commands\ArchiveShoppingList;

interface ArchiveShoppingListCommandInterface
{
    /**
     * Archive a shopping list.
     *
     * @param ArchiveShoppingListModel $model
     * @return void
     */
    public function execute(ArchiveShoppingListModel $model): void;
}
