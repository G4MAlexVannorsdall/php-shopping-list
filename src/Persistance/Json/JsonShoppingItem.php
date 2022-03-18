<?php
declare(strict_types=1);

namespace Lindyhopchris\ShoppingList\Persistance\Json;

use JsonSerializable;
use Lindyhopchris\ShoppingList\Domain\ShoppingItem;

class JsonShoppingItem implements JsonSerializable
{
    /**
     * @var ShoppingItem
     */
    private ShoppingItem $item;

    /**
     * @param ShoppingItem $item
     */
    public function __construct(ShoppingItem $item)
    {
        $this->item = $item;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->item->getId(),
            'name' => $this->item->getName(),
            'completed' => $this->item->isCompleted(),
        ];
    }
}
