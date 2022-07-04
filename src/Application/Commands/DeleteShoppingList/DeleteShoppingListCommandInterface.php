<?php

namespace Lindyhopchris\ShoppingList\Application\Commands\DeleteShoppingList;

interface DeleteShoppingListCommandInterface
{
    /**
     * Delete a shopping list
     *
     * @param DeleteShoppingListModel $model
     */
    public function execute(DeleteShoppingListModel $model): void;
}
