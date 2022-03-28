<?php
declare(strict_types=1);

namespace Lindyhopchris\ShoppingList\Application\Commands\AddShoppingItem;

class AddShoppingItemModel
{
    /**
     * @var string
     */
    private string $list;

    /**
     * @var string
     */
    private string $name;

    /**
     * @param string $list
     * @param string $name
     */
    public function __construct(string $list, string $name)
    {
        $this->list = $list;
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getList(): string
    {
        return $this->list;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
