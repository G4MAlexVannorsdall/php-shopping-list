<?php
declare(strict_types=1);

namespace Lindyhopchris\ShoppingList\Application\Queries\GetShoppingListNames;

use Lindyhopchris\ShoppingList\Persistance\ShoppingListNotFoundException;

interface GetShoppingListNamesQueryInterface
{
    /**
     * Get the shopping list names.
     *
     * @param GetShoppingListNamesRequest $request
     * @return ShoppingListNamesModel
     * @throws ShoppingListNotFoundException
     */
    public function execute(GetShoppingListNamesRequest $request): ShoppingListNamesModel;
}
