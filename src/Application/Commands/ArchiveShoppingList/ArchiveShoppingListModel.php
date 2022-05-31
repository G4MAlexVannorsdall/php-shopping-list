<?php

declare(strict_types=1);

namespace Lindyhopchris\ShoppingList\Application\Commands\ArchiveShoppingList;

class ArchiveShoppingListModel
{
    /**
     * @var string
     */
    private string $list;

    /**
     * ArchiveShoppingListModel constructor.
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
