<?php
declare(strict_types=1);

namespace Lindyhopchris\ShoppingList\Application\Commands\AddShoppingItem;

use Lindyhopchris\ShoppingList\Domain\ShoppingItem;
use Lindyhopchris\ShoppingList\Domain\ShoppingItemStack;

class AddShoppingItemFactory
{
    /**
     * Create a new shopping item.
     *
     * @param ShoppingItemStack $existing
     * @param string $name
     * @return ShoppingItem
     */
    public function make(ShoppingItemStack $existing, string $name): ShoppingItem
    {
        return new ShoppingItem(
            $existing->maxId() + 1,
            $name,
        );
    }
}
