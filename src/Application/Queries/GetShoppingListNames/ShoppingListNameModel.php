<?php

namespace Lindyhopchris\ShoppingList\Application\Queries\GetShoppingListNames;

class ShoppingListNameModel
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
     * ShoppingListNameModel constructor.
     *
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
