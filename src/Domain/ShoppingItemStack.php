<?php
declare(strict_types=1);

namespace Lindyhopchris\ShoppingList\Domain;

use Countable;
use IteratorAggregate;
use LogicException;
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
     * Return a new shopping item stack with the provided item appended.
     *
     * @param ShoppingItem $item
     * @return ShoppingItemStack
     */
    public function push(ShoppingItem $item): self
    {
        if ($this->hasId($item->getId())) {
            throw new LogicException('Cannot add item with duplicate id.');
        }

        $copy = clone $this;
        $copy->items[] = $item;

        return $copy;
    }

    /**
     * Delete/remove a shopping item.
     *
     * @param ShoppingItem $itemToRemove
     * @return $this
     */
    public function remove(ShoppingItem $itemToRemove): self
    {
        // Get the list first, then get the items on the list
        $stack = $this->all();

        $items = [];
        foreach ($stack as $item) {
            if ($item->getId() === $itemToRemove->getId()) {
                continue;
            }
            $items[] = $item;
        }
        // If the list is not empty, and you find the id of the item to be deleted
            // Delete the item
        return new ShoppingItemStack(...$items);
    }

    /**
     * Does an item with the provided id exist in the stack?
     *
     * @param int $id
     * @return bool
     */
    public function hasId(int $id): bool
    {
        foreach ($this->items as $item) {
            if ($id === $item->getId()) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get the highest id in the stack.
     *
     * @return int|null
     */
    public function maxId(): ?int
    {
        $max = null;

        foreach ($this->items as $item) {
            if ($max < $item->getId()) {
                $max = $item->getId();
            }
        }

        return $max;
    }

    /**
     * Select a shopping item from the stack.
     *
     * @param callable $callback
     * @return ShoppingItem|null
     */
    public function select(callable $callback): ?ShoppingItem
    {
        foreach ($this->items as $item) {
            if (true === $callback($item)) {
                return $item;
            }
        }

        return null;
    }
}
