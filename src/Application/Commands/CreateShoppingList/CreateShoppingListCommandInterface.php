<?php
declare(strict_types=1);

namespace Lindyhopchris\ShoppingList\Application\Commands\CreateShoppingList;

use Lindyhopchris\ShoppingList\Common\Validation\ValidationException;

interface CreateShoppingListCommandInterface
{
    /**
     * Create a new shopping list.
     *
     * @param CreateShoppingListModel $model
     * @return void
     * @throws ValidationException
     */
    public function execute(CreateShoppingListModel $model): void;
}
