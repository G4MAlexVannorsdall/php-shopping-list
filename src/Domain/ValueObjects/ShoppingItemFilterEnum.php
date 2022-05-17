<?php

namespace Lindyhopchris\ShoppingList\Domain\ValueObjects;

class ShoppingItemFilterEnum
{
    /**
     * @var string
     */
    private string $all;

    /**
     * @param string $all
     */
    public function __construct(string $all)
    {
        $this->all = $all;
    }

    /**
     * Get all the items on the shopping list.
     *
     * @return bool
     */
    public function all(): bool
    {
        return $this->all;
    }

    /**
     * Get only completed (check off) items on the shopping list.
     *
     * @return bool
     */
    public function onlyCompleted(): bool
    {
        return $this->onlyCompleted();
    }

    /**
     * Get only not completed (not checked off) items on the shopping list.
     *
     * @return bool
     */
    public function onlyNotCompleted(): bool
    {
        return $this->onlyNotCompleted();
    }
}
