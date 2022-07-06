<?php
declare(strict_types=1);

namespace Lindyhopchris\ShoppingList\Persistance\Json;

use Lindyhopchris\ShoppingList\Domain\ShoppingList;
use Lindyhopchris\ShoppingList\Persistance\ShoppingListNotFoundException;
use Lindyhopchris\ShoppingList\Persistance\ShoppingListRepositoryInterface;

class JsonShoppingListRepository implements ShoppingListRepositoryInterface
{
    /**
     * @var JsonFileHandler
     */
    private JsonFileHandler $files;

    /**
     * @var JsonShoppingListFactory
     */
    private JsonShoppingListFactory $factory;

    /**
     * @param JsonFileHandler $files
     * @param JsonShoppingListFactory $factory
     */
    public function __construct(JsonFileHandler $files, JsonShoppingListFactory $factory)
    {
        $this->files = $files;
        $this->factory = $factory;
    }

    /**
     * @inheritDoc
     */
    public function exists(string $slug): bool
    {
        return $this->files->exists(
            $this->storeAs($slug)
        );
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
    public function findOrFail(string $slug): ShoppingList
    {
        if ($list = $this->find($slug)) {
            return $list;
        }

        throw new ShoppingListNotFoundException("Shopping list '{$slug}' does not exist.");
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

    public function unlink(ShoppingList $slug): void
    {
        $filename = $this->storeAs($slug);

        if ($this->files->exists($filename)) {
            $this->unlink($slug);
        }
    }

}
