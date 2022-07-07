<?php
declare(strict_types=1);

namespace Lindyhopchris\ShoppingList\Application\Commands\DeleteShoppingList;

class DeleteShoppingListModel
{
    /**
     * @var string
     */
    private string $list;

    /**
     * DeleteShoppingListModel constructor.
     *
     * @param string $list
     */
    public function __construct(string $list)
    {
        $this->list = $list;
    }

    /**
     * @return string
     */
    public function getList(): string
    {
        return $this->list;
    }
}
