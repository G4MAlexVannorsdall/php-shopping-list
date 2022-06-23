<?php

declare(strict_types=1);

namespace Lindyhopchris\ShoppingList\Application\Commands\ArchiveShoppingList;

use Lindyhopchris\ShoppingList\Common\Validation\ValidationException;

interface ArchiveShoppingListCommandInterface
{
    /**
     * Archive a shopping list.
     *
     * @param ArchiveShoppingListModel $model
     * @return void
     * @throws ValidationException
     */
    public function execute(ArchiveShoppingListModel $model): void;
}
