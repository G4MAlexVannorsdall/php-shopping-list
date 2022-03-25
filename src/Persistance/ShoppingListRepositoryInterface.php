<?php
declare(strict_types=1);

namespace Lindyhopchris\ShoppingList\Persistance;

use Lindyhopchris\ShoppingList\Domain\ShoppingList;

interface ShoppingListRepositoryInterface
{
    /**
     * Does a shopping list identified by the supplied slug exist?
     *
     * @param string $slug
     * @return bool
     */
    public function exists(string $slug): bool;

    /**
     * Retrieve a shopping list by its slug.
     *
     * @param string $slug
     * @return ShoppingList|null
     */
    public function find(string $slug): ?ShoppingList;

    /**
     * Store (create or update) a shopping list.
     *
     * @param ShoppingList $list
     * @return void
     */
    public function store(ShoppingList $list): void;
}
