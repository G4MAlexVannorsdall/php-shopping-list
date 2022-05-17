<?php

namespace Lindyhopchris\ShoppingList\Domain\ValueObjects;

use http\Exception\InvalidArgumentException;

class ShoppingItemFilterEnum
{

    const ONE = 'all';
    const TWO = 'only completed';
    const THREE = 'only not completed';

    function showConstant()
    {
        echo self::ONE;
        echo self::TWO;
        echo self::THREE;
    }
    /**
     * @var string
     */
    private string $value;

    /**
     * @param string $value
     */
    public function __construct(string $value)
    {
        if ($value !== self::ONE || self::TWO || self::THREE) {
            throw new InvalidArgumentException('This was not a valid search.');
        }

        $this->value = $value;
    }

    /**
     * Get all the items on the shopping list.
     *
     * @return bool
     */
    public function value(): bool
    {
        return $this->value;
    }

    /**
     * Get only completed (check off) items on the shopping list.
     *
     * @return bool
     */
    public function onlyCompleted(): bool
    {
        return self::TWO;
    }

    /**
     * Get only not completed (not checked off) items on the shopping list.
     *
     * @return bool
     */
    public function onlyNotCompleted(): bool
    {
        return self::THREE;
    }
}
