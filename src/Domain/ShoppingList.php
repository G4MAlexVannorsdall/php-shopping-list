<?php

declare(strict_types=1);

namespace Lindyhopchris\ShoppingList\Domain;

use InvalidArgumentException;

class ShoppingList
{
    /**
     * @var string
     */
    private string $slug;

    /**
     * @var string
     */
    private string $name;

    /**
     * @var ShoppingItemStack
     */
    private ShoppingItemStack $items;

    /**
     * @param string $slug
     * @param string $name
     * @param ShoppingItemStack|null $items
     */
    public function __construct(string $slug, string $name, ShoppingItemStack $items = null)
    {
        $this->slug = $this->assertSlug($slug);
        $this->setName($name);
        $this->items = $items ?? new ShoppingItemStack();
    }

    /**
     * Get the shopping list unique slug.
     *
     * @return string
     */
    public function getSlug(): string
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
     * @param string $slug
     * @return string
     */
    private function assertSlug(string $slug): string
    {
        $check = preg_match('/^[a-z][a-z\-]{2,}[a-z]$/', $slug);

        if (false === $check || 0 === $check) {
            throw new InvalidArgumentException('Invalid shopping list slug.');
        }

        return $slug;
    }
}
