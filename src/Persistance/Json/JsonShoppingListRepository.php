<?php
declare(strict_types=1);

namespace Lindyhopchris\ShoppingList\Persistance\Json;

use Lindyhopchris\ShoppingList\Domain\ShoppingList;
use Lindyhopchris\ShoppingList\Persistance\ShoppingListRepositoryInterface;

class JsonShoppingListRepository implements ShoppingListRepositoryInterface
{
    /**
     * @var JsonFileHandler
     */
    private JsonFileHandler $files;

    /**
     * @var ShoppingListFactory
     */
    private ShoppingListFactory $factory;

    /**
     * @param JsonFileHandler $files
     * @param ShoppingListFactory $factory
     */
    public function __construct(JsonFileHandler $files, ShoppingListFactory $factory)
    {
        $this->files = $files;
        $this->factory = $factory;
    }

    /**
     * @inheritDoc
     */
    public function find(string $slug): ?ShoppingList
    {
        $filename = $this->storeAs($slug);

        if ($this->files->exists($filename)) {
            return $this->factory->make(
                $this->files->decode($filename)
            );
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    public function store(ShoppingList $list): void
    {
        $this->files->write(
            $this->storeAs($list),
            new JsonShoppingList($list),
        );
    }

    /**
     * @param ShoppingList|string $slug
     * @return string
     */
    private function storeAs(ShoppingList|string $slug): string
    {
        if ($slug instanceof ShoppingList) {
            $slug = $slug->getSlug();
        }

        return $slug . '.json';
    }
}
