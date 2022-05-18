<?php

namespace Lindyhopchris\ShoppingList\Application\Queries\GetShoppingListDetail;

class GetShoppingListDetailRequest
{
    public string $slug;
    public int $filterValue;

    public function __construct(string $slug, int $filterValue)
    {
        $this->slug = $slug;
        $this->filterValue = $filterValue;
    }

    private function getSlug(): string
    {
        return $this->slug;
    }

    private function getFilterValue(): int
    {
        return $this->filterValue;
    }
}
