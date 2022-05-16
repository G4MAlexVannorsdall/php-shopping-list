<?php
declare(strict_types=1);

namespace Lindyhopchris\ShoppingList\Domain;

class ShoppingItem
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var string
     */
    private string $name;

    /**
     * @var bool
     */
    private bool $completed;

    /**
     * @param int $id
     * @param string $name
     * @param bool $completed
     */
    public function __construct(int $id, string $name, bool $completed = false)
    {
        $this->id = $id;
        $this->name = $name;
        $this->completed = $completed;
    }

    /**
     * Get the id of the shopping item.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get the name of the shopping item.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Is the item completed (aka checked off)?
     *
     * @return bool
     */
    public function isCompleted(): bool
    {
        return $this->completed;
    }

    /**
     * Is the item not completed (not checked off?)
     *
     * @return bool
     */
    public function isNotCompleted(): bool
    {
        return $this->completed === false;
    }

    /**
     * Mark the item as completed (aka checked off).
     *
     * @return void
     */
    public function markAsCompleted(): void
    {
        $this->completed = true;
    }
}
