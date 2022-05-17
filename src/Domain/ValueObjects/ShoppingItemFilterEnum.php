<?php

namespace Lindyhopchris\ShoppingList\Domain\ValueObjects;

class ShoppingItemFilterEnum
{
    /**
     * @var string
     */
    private string $all;

    /**
     * @var bool
     */
    private bool $onlyCompleted;

    /**
     * @var bool
     */
    private bool $onlyNotCompleted;

    public function __construct(string $all, bool $onlyCompleted, bool $onlyNotCompleted)
    {
        $this->all = $all;
        $this->onlyCompleted = $onlyCompleted;
        $this->onlyNotCompleted = $onlyNotCompleted;
    }

    /**
     * Get all the items on the shopping list.
     *
     * @return string
     */
    public function all(): string
    {
        return $this->all;
    }

    /**
     * Get only the completed (checked off) items on the shopping list.
     *
     * @return bool
     */
    public function onlyCompleted(): bool
    {
        return $this->onlyCompleted;
    }

    /**
     * Get only the items on the shopping list that aren't complete (checked off).
     *
     * @return bool
     */
    public function onlyNotCompleted(): bool
    {
        return $this->onlyNotCompleted;
    }

}
