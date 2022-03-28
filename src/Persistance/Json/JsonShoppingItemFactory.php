<?php
declare(strict_types=1);

namespace Lindyhopchris\ShoppingList\Persistance\Json;

use Lindyhopchris\ShoppingList\Domain\ShoppingItem;
use Lindyhopchris\ShoppingList\Domain\ShoppingItemStack;
use RuntimeException;

class JsonShoppingItemFactory
{
    /**
     * Make a shopping item entity from an array of values.
     *
     * @param array $values
     * @return ShoppingItem
     */
    public function make(array $values): ShoppingItem
    {
        if (!isset($values['id'], $values['name'], $values['completed'])) {
            throw new RuntimeException('Invalid shopping item array.');
        }

        return new ShoppingItem(
            $values['id'],
            $values['name'],
            $values['completed'],
        );
    }

    /**
     * Make a stack of shopping items from an array.
     *
     * @param array $values
     * @return ShoppingItemStack
     */
    public function makeMany(array $values): ShoppingItemStack
    {
        return new ShoppingItemStack(...array_map(
            fn (array $value): ShoppingItem => $this->make($value),
            $values,
        ));
    }
}
