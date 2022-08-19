<?php
declare(strict_types=1);

namespace Lindyhopchris\ShoppingList\Application\Queries\GetShoppingListNames;

use Lindyhopchris\ShoppingList\Persistance\ShoppingListNotFoundException;

interface GetShoppingListNamesQueryInterface
{
    /**
     * Get the shopping lists names.
     *
     * @param GetShoppingListNamesRequest $request
     * @throws ShoppingListNotFoundException
     */
    public function execute(GetShoppingListNamesRequest $request): array;
}
