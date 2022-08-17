<?php

namespace Lindyhopchris\ShoppingList\Application\Queries\GetShoppingListNames;

class GetShoppingListNamesRequest
{
    /**
     * @var string
     */
    private string $filterValue;

    /**
     * @param string $filterValue
     */
    public function __construct(string $filterValue)
    {
        $this->filterValue = $filterValue;
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
}
