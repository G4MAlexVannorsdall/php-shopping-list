<?php
declare(strict_types=1);

namespace Lindyhopchris\ShoppingList\Persistance\Json;

use Lindyhopchris\ShoppingList\Domain\ShoppingList;
use Lindyhopchris\ShoppingList\Domain\ValueObjects\Slug;
use RuntimeException;

class JsonShoppingListFactory
{
    /**
     * @var JsonShoppingItemFactory
     */
    private JsonShoppingItemFactory $itemFactory;

    /**
     * @param JsonShoppingItemFactory $itemFactory
     */
    public function __construct(JsonShoppingItemFactory $itemFactory)
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
            true,
            $this->itemFactory->makeMany($values['items']),
        );
    }
}
