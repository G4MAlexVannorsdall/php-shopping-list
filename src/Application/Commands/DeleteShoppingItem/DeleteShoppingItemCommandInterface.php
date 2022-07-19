<?php

namespace Lindyhopchris\ShoppingList\Application\Commands\DeleteShoppingItem;

/**
 * Delete a shopping item.
 *
 * @param DeleteShoppingItemModel $model
 * @return void
 */
interface DeleteShoppingItemCommandInterface
{
    public function execute(DeleteShoppingItemModel $model): void;
}
