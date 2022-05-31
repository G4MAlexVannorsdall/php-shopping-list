<?php
declare(strict_types=1);

namespace Lindyhopchris\ShoppingList\Application\Commands\CreateShoppingList;

use Lindyhopchris\ShoppingList\Domain\ValueObjects\Slug;
use Lindyhopchris\ShoppingList\Domain\ShoppingList;

class CreateShoppingListFactory
{
    /**
     * Create a new shopping list.
     *
     * @param string $slug
     * @param string $name
     * @param $items
     * @param bool $isArchived
     * @return ShoppingList
     */
    public function make(string $slug, string $name, $items, bool $isArchived): ShoppingList
    {
        return new ShoppingList(
            new Slug($slug),
            $name,
            $items,
            $isArchived,

        );
    }
}
