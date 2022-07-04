<?php
declare(strict_types=1);

namespace Lindyhopchris\ShoppingList\Application\Commands\DeleteShoppingList;

class DeleteShoppingListModel
{
    /**
     * @var string
     */
    private string $slug;

    /**
     * DeleteShoppingListModel constructor.
     *
     *
     * @param string $slug
     */
    public function __construct(string $slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }
}
