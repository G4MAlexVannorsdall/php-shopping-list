<?php

namespace Lindyhopchris\ShoppingList\Application\Commands\DeleteShoppingList;

use Lindyhopchris\ShoppingList\Persistance\Json\JsonFileHandler;

class DeleteShoppingListCommand implements DeleteShoppingListCommandInterface
{
    /**
     * @var JsonFileHandler
     */
    private JsonFileHandler $fileHandler;

    /**
     * @param JsonFileHandler $fileHandler
     */
    public function __construct(JsonFileHandler $fileHandler)
    {
        $this->fileHandler = $fileHandler;
    }

    /**
     * @param DeleteShoppingListModel $model
     */
    public function execute(DeleteShoppingListModel $model): void
    {
        $list = $this->fileHandler->exists(
            $model->getSlug(),
        );


      // Here I will put a line of code that deletes the list.
    }
}
