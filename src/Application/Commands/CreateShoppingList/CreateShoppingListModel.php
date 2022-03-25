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

    /**
     * @param string $slug
     * @param string $name
     */
    public function __construct(string $slug, string $name)
    {
        $this->slug = $slug;
        $this->name = $name;
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
}
