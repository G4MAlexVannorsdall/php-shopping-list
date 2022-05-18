<?php
declare(strict_types=1);

namespace Lindyhopchris\ShoppingList\Application\Queries\GetShoppingListDetail;

use Countable;
use Generator;
use IteratorAggregate;
use RuntimeException;

class ShoppingListDetailModel implements IteratorAggregate, Countable
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
     * @var ShoppingItemDetailModel[]
     */
    private array $items = [];

    /**
     * ShoppingListDetailModel constructor.
     *
     * @param string $slug
     * @param string $name
     * @param array $items
     */
    public function __construct(string $slug, string $name, array $items)
    {
        $this->slug = $slug;
        $this->name = $name;
        $this->addItems($items);
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

    /**
     * @return ShoppingItemDetailModel[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @inheritDoc
     */
    public function getIterator(): Generator
    {
        yield from $this->items;
    }

    /**
     * @inheritDoc
     */
    public function count(): int
    {
        return count($this->items);
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->items);
    }

    /**
     * @param array $items
     * @return void
     */
    private function addItems(array $items): void
    {
        foreach ($items as $item) {
            if ($item instanceof ShoppingItemDetailModel) {
                $this->items[] = $item;
                continue;
            }

            throw new RuntimeException('Expecting only shopping item detail models.');
        }
    }
}
