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
}
