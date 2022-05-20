<?php
declare(strict_types=1);

namespace Lindyhopchris\ShoppingList\Application\Queries\GetShoppingListDetail;

use Lindyhopchris\ShoppingList\Persistance\ShoppingListNotFoundException;

interface GetShoppingListDetailQueryInterface
{
    /**
     * Get the shopping list detail for the provided slug.
     *
     * @param GetShoppingListDetailRequest $request
     * @return ShoppingListDetailModel
     * @throws ShoppingListNotFoundException
     */
    public function execute(GetShoppingListDetailRequest $request): ShoppingListDetailModel;
}
