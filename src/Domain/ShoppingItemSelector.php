<?php
declare(strict_types=1);

namespace Lindyhopchris\ShoppingList\Domain;

class ShoppingItemSelector
{
    /**
     * @var string|int
     */
    private string|int $value;

    /**
     * @var bool|null
     */
    private ?bool $completed;

    /**
     * ShoppingItemSelector constructor.
     *
     * @param int|string $value
     * @param bool|null $completed
     */
    public function __construct(int|string $value, bool $completed = null)
    {
        $this->value = $value;
        $this->completed = $completed;
    }

    /**
     * Is the shopping item the one to select?
     *
     * @param ShoppingItem $item
     * @return bool
     */
    public function __invoke(ShoppingItem $item): bool
    {
        if (is_bool($this->completed) && $this->completed !== $item->isCompleted()) {
            return false;
        }

        if (is_int($this->value)) {
            return $this->value === $item->getId();
        }

        return strtolower($this->value) === strtolower($item->getName());
    }
}
