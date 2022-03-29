<?php
declare(strict_types=1);

namespace Lindyhopchris\ShoppingList\Application\Queries\GetShoppingListDetail;

class ShoppingItemDetailModel
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
     * ShoppingItemDetailModel constructor.
     *
     * @param int $id
     * @param string $name
     * @param bool $completed
     */
    public function __construct(int $id, string $name, bool $completed)
    {
        $this->id = $id;
        $this->name = $name;
        $this->completed = $completed;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function isCompleted(): bool
    {
        return $this->completed;
    }
}
