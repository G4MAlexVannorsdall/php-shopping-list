<?php

namespace Lindyhopchris\ShoppingList\Application\Queries\GetShoppingListNames;

class GetShoppingListNamesRequest
{
    /**
     * @var string
     */
    private string $filterValue;

    /**
     * @var string
     */
    private string $slug;

    /**
     * @param string $filterValue
     * @param string $slug
     */
    public function __construct(string $filterValue, string $slug)
    {
        $this->filterValue = $filterValue;
        $this->slug = $slug;
    }

    /**
     * Returns whether the list is archived.
     *
     * @return string
     */
    public function getFilterValue(): string
    {
        return $this->filterValue;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

}
