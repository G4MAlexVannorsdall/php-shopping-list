<?php
declare(strict_types=1);

namespace Lindyhopchris\ShoppingList\Persistance\Json;

use Lindyhopchris\ShoppingList\Domain\ShoppingList;
use Lindyhopchris\ShoppingList\Domain\Slug;
use RuntimeException;

class ShoppingListFactory
{
    /**
     * @var ShoppingItemFactory
     */
    private ShoppingItemFactory $itemFactory;

    /**
     * @param ShoppingItemFactory $itemFactory
     */
    public function __construct(ShoppingItemFactory $itemFactory)
    {
        $this->itemFactory = $itemFactory;
    }

    /**
     * Make a shopping list entity from an array of values.
     *
     * @param array $values
     * @return ShoppingList
     */
    public function make(array $values): ShoppingList
    {
        if (!isset($values['slug'], $values['name'], $values['items'])) {
            throw new RuntimeException('Invalid shopping list array.');
        }

        return new ShoppingList(
            new Slug($values['slug']),
            $values['name'],
            $this->itemFactory->makeMany($values['items']),
        );
    }
}
