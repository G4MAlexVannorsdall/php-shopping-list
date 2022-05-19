<?php

namespace Lindyhopchris\ShoppingList\Application\Queries\GetShoppingListDetail;

class GetShoppingListDetailRequest
{
    /**
     * @var string
     */
    private string $slug;

    /**
     * @var string
     */
    private string $filterValue;

    /**
     * @param string $slug
     * @param string $filterValue
     */
    public function __construct(string $slug, string $filterValue)
    {
        $this->slug = $slug;
        $this->filterValue = $filterValue;
    }

    /**
     * Returns the slug (title) of the list.
     *
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * Returns whether the user requested all, complete, or not complete items of the list.
     *
     * @return string
     */
    public function getFilterValue(): string
    {
        return $this->filterValue;
    }
}
