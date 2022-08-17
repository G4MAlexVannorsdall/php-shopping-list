<?php
declare(strict_types = 1);

namespace Lindyhopchris\ShoppingList\Domain\ValueObjects;

class ShoppingListFilterEnum
{
    public const ALL = 'all';
    public const ONLY_ARCHIVED = 'archived';
    public const ONLY_NOT_ARCHIVED = 'not-archived';

    /**
     * @var string
     */
    private string $value;

    /**
     * @param string $value
     */
    public function __construct(string $value)
    {
        if ($value !== self::ALL && $value !== self::ONLY_ARCHIVED && $value !== self::ONLY_NOT_ARCHIVED) {
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
     * Get all shopping lists.
     *
     * @return bool
     */
    public function all(): bool
    {
        return self::ALL === $this->value;
    }

    /**
     * Get only archived shopping lists.
     *
     * @return bool
     */
    public function onlyArchived(): bool
    {
        return self::ONLY_ARCHIVED === $this->value;
    }

    /**
     * Get only non-archived shopping lists.
     *
     * @return bool
     */
    public function onlyNotArchived(): bool
    {
        return self::ONLY_NOT_ARCHIVED === $this->value;
    }
}
