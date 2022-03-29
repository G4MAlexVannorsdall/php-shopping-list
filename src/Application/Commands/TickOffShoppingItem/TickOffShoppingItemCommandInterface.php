<?php
declare(strict_types=1);

namespace Lindyhopchris\ShoppingList\Application\Commands\TickOffShoppingItem;

use Lindyhopchris\ShoppingList\Common\Validation\ValidationException;

interface TickOffShoppingItemCommandInterface
{
    /**
     * Tick off a shopping item.
     *
     * @param TickOffShoppingItemModel $model
     * @return void
     * @throws ValidationException
     */
    public function execute(TickOffShoppingItemModel $model): void;
}
