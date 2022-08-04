<?php

declare(strict_types=1);

namespace Lindyhopchris\ShoppingList\Domain;

use InvalidArgumentException;
use Lindyhopchris\ShoppingList\Domain\ValueObjects\Slug;

class ShoppingList
{
    /**
     * @var Slug
     */
    private Slug $slug;

    /**
     * @var string
     */
    private string $name;

    /**
     * @var ShoppingItemStack
     */
    private ShoppingItemStack $items;

    /**
     * @var bool
     */
    private bool $isArchived;

    /**
     * @param Slug $slug
     * @param string $name
     * @param ShoppingItemStack|null $items
     * @param bool|false $isArchived
     */
    public function __construct(Slug $slug, string $name, bool $isArchived = false, ShoppingItemStack $items = null)
    {
        $this->slug = $slug;
        $this->setName($name);
        $this->isArchived = $isArchived;
        $this->items = $items ?? new ShoppingItemStack();
    }

    /**
     * Get the shopping list unique slug.
     *
     * @return Slug
     */
    public function getSlug(): Slug
    {
        return $this->slug;
    }

    /**
     * Get the shopping list name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the shopping list name.
     *
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        if (!empty($name)) {
            $this->name = $name;
            return $this;
        }

        throw new InvalidArgumentException('Expecting a non-empty shopping list name.');
    }

    /**
     * @return ShoppingItemStack
     */
    public function getItems(): ShoppingItemStack
    {
        return $this->items;
    }

    /**
     * Get whether an item has been archived.
     *
     * @return bool
     */
    public function isArchived(): bool
    {
        return $this->isArchived;
    }

    /**
     * Set whether an item is archived.
     * @param $isArchived bool
     * @return self
     */
    public function setArchived(bool $isArchived): self
    {
        $this->isArchived = $isArchived;
        return $this;
    }

    /**
     * Add a new shopping item.
     *
     * @param ShoppingItem $item
     * @return void
     */
    public function addItem(ShoppingItem $item): void
    {
        $this->items = $this->items->push($item);
    }

    /**
     * Remove/delete a shopping item.
     *
     * @param ShoppingItem $item
     * @return void
     */
    public function removeItem(ShoppingItem $item): void
    {
        $this->items = $this->items->remove($item);

        $deletedId = $item->getId();

       foreach ($this->getItems() as $item) {
           if ($item->getId() >= $deletedId) {
             $item->setId($item->getId() - 1);
           }
       }
    }
}

