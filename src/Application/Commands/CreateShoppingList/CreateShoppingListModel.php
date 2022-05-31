<?php
declare(strict_types=1);

namespace Lindyhopchris\ShoppingList\Application\Commands\CreateShoppingList;

class CreateShoppingListModel
{
    /**
     * @var string
     */
    private string $slug;

    /**
     * @var string
     */
    private string $name;

    private bool $isArchived;

    /**
     * @param string $slug
     * @param string $name
     */
    public function __construct(string $slug, string $name, bool $isArchived)
    {
        $this->slug = $slug;
        $this->name = $name;
        $this->isArchived = $isArchived;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function isArchived(): bool
    {
        return $this->isArchived;
    }
}
