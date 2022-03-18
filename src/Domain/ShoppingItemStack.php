<?php
declare(strict_types=1);

namespace Lindyhopchris\ShoppingList\Domain;

use Countable;
use IteratorAggregate;
use Traversable;

class ShoppingItemStack implements IteratorAggregate, Countable
{
    /**
     * @var ShoppingItem[]
     */
    private array $items;

    /**
     * @param ShoppingItem ...$items
     */
    public function __construct(ShoppingItem ...$items)
    {
        $this->items = $items;
    }

    /**
     * @inheritDoc
     */
    public function getIterator(): Traversable
    {
        yield from $this->items;
    }

    /**
     * @inheritDoc
     */
    public function count(): int
    {
        return count($this->items);
    }

    /**
     * @return ShoppingItem[]
     */
    public function all(): array
    {
        return $this->items;
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->items);
    }

    /**
     * @return bool
     */
    public function isNotEmpty(): bool
    {
        return !$this->isEmpty();
    }

    /**
     * Add a shopping item to the end of the list.
     *
     * @param ShoppingItem $item
     * @return $this
     */
    public function push(ShoppingItem $item): self
    {
        $this->items[] = $item;

        return $this;
    }
}
