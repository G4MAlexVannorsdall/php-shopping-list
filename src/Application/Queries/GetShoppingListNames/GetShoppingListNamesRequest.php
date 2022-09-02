<?php

namespace Lindyhopchris\ShoppingList\Application\Queries\GetShoppingListNames;

class GetShoppingListNamesRequest
{
    /**
     * @var string|null
     */
    private ?string $filterValue;

    /**
     * @param string|null $filterValue
     */
    public function __construct(string $filterValue = null)
    {
        $this->filterValue = $filterValue;
    }

    /**
     * Returns whether the list is archived.
     *
     * @return string|null
     */
    public function getFilterValue(): ?string
    {
        return $this->filterValue;
    }
}
