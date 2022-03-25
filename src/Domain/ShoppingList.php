<?php

declare(strict_types=1);

namespace Lindyhopchris\ShoppingList\Domain;

use InvalidArgumentException;

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
     * @param Slug $slug
     * @param string $name
     * @param ShoppingItemStack|null $items
     */
    public function __construct(Slug $slug, string $name, ShoppingItemStack $items = null)
    {
        $this->slug = $slug;
        $this->setName($name);
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
}
