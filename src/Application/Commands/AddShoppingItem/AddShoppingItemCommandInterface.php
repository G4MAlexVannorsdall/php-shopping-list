<?php
declare(strict_types=1);

namespace Lindyhopchris\ShoppingList\Application\Commands\AddShoppingItem;

use Lindyhopchris\ShoppingList\Common\Validation\ValidationException;

interface AddShoppingItemCommandInterface
{
    /**
     * Add a shopping item.
     *
     * @param AddShoppingItemModel $model
     * @return void
     * @throws ValidationException
     */
    public function execute(AddShoppingItemModel $model): void;
}
