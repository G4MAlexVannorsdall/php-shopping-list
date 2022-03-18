<?php
declare(strict_types=1);

namespace Lindyhopchris\ShoppingList\Persistance\Json;

use Generator;
use JsonSerializable;
use Lindyhopchris\ShoppingList\Domain\ShoppingList;

class JsonShoppingList implements JsonSerializable
{
    /**
     * @var ShoppingList
     */
    private ShoppingList $list;

    /**
     * @param ShoppingList $list
     */
    public function __construct(ShoppingList $list)
    {
        $this->list = $list;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        return [
            'slug' => $this->list->getSlug(),
            'name' => $this->list->getName(),
            'items' => iterator_to_array($this->items()),
        ];
    }

    /**
     * @return Generator
     */
    private function items(): Generator
    {
        foreach ($this->list->getItems() as $item) {
            yield new JsonShoppingItem($item);
        }
    }
}
