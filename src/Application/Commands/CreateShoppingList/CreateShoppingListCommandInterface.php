<?php
declare(strict_types=1);

namespace Lindyhopchris\ShoppingList\Application\Commands\CreateShoppingList;

interface CreateShoppingListCommandInterface
{
    /**
     * Create a new shopping list.
     *
     * @param CreateShoppingListModel $model
     * @return void
     * @throws CreateShoppingListException
     */
    public function execute(CreateShoppingListModel $model): void;
}
