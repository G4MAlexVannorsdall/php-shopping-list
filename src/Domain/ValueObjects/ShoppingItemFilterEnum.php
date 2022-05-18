<?php
declare(strict_types = 1);

namespace Lindyhopchris\ShoppingList\Domain\ValueObjects;

class ShoppingItemFilterEnum
{

    public const ALL = 'all';
    public const ONLY_COMPLETED = 'only completed';
    public const ONLY_NOT_COMPLETED = 'only not completed';

    /**
     * @var string
     */
    private string $value;

    /**
     * @param string $value
     */
    public function __construct(string $value)
    {
        if ($value !== self::ALL && $value !== self::ONLY_COMPLETED && $value !== self::ONLY_NOT_COMPLETED) {
            throw new \InvalidArgumentException('This was not a valid search.');
        }

        $this->value = $value;
    }

    /**
     * Returns the value.
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Get all items of the shopping list.
     *
     * @return bool
     */
    public function all(): bool
    {
        return self::ALL === $this->value;
    }

    /**
     * Get only completed (check off) items on the shopping list.
     *
     * @return bool
     */
    public function onlyCompleted(): bool
    {
        return self::ONLY_COMPLETED === $this->value;
    }

    /**
     * Get only not completed (not checked off) items on the shopping list.
     *
     * @return bool
     */
    public function onlyNotCompleted(): bool
    {
        return self::ONLY_NOT_COMPLETED === $this->value;
    }
}
