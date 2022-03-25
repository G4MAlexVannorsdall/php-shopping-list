<?php
declare(strict_types=1);

namespace Lindyhopchris\ShoppingList;

use Lindyhopchris\ShoppingList\Application\Commands\CreateShoppingList\CreateShoppingListCommand;
use Lindyhopchris\ShoppingList\Application\Commands\CreateShoppingList\CreateShoppingListCommandInterface;
use Lindyhopchris\ShoppingList\Application\Commands\CreateShoppingList\ShoppingListFactory;
use Lindyhopchris\ShoppingList\Application\Commands\CreateShoppingList\Validation\CreateShoppingListValidator;
use Lindyhopchris\ShoppingList\Application\Commands\CreateShoppingList\Validation\Rules\ShoppingListNameIsNotEmpty;
use Lindyhopchris\ShoppingList\Application\Commands\CreateShoppingList\Validation\Rules\ShoppingListSlugMatchesPattern;
use Lindyhopchris\ShoppingList\Application\Commands\CreateShoppingList\Validation\Rules\ShoppingListSlugMustBeUnique;
use Lindyhopchris\ShoppingList\Persistance\Json\JsonFileHandler;
use Lindyhopchris\ShoppingList\Persistance\Json\JsonShoppingListRepository;
use Lindyhopchris\ShoppingList\Persistance\Json\ShoppingItemFactory as JsonShoppingItemFactory;
use Lindyhopchris\ShoppingList\Persistance\Json\ShoppingListFactory as JsonShoppingListFactory;
use Lindyhopchris\ShoppingList\Persistance\ShoppingListRepositoryInterface;

class Container
{
    /**
     * @var Container|null
     */
    private static ?self $container = null;

    /**
     * @var ShoppingListRepositoryInterface|null
     */
    private ?ShoppingListRepositoryInterface $shoppingListRepository = null;

    /**
     * @return static
     */
    public static function getInstance(): self
    {
        if (self::$container) {
            return self::$container;
        }

        return self::$container = new self();
    }

    /**
     * Get a create shopping list command instance.
     *
     * @return CreateShoppingListCommandInterface
     */
    public function getCreateShoppingListCommand(): CreateShoppingListCommandInterface
    {
        $repository = $this->getShoppingListRepository();

        $validator = new CreateShoppingListValidator(
            new ShoppingListSlugMatchesPattern(),
            new ShoppingListSlugMustBeUnique($repository),
            new ShoppingListNameIsNotEmpty(),
        );

        return new CreateShoppingListCommand(
            $validator,
            new ShoppingListFactory(),
            $repository,
        );
    }

    /**
     * Get the shopping list repository singleton.
     *
     * @return ShoppingListRepositoryInterface
     */
    private function getShoppingListRepository(): ShoppingListRepositoryInterface
    {
        if ($this->shoppingListRepository) {
            return $this->shoppingListRepository;
        }

        return $this->shoppingListRepository = new JsonShoppingListRepository(
            new JsonFileHandler(__DIR__ . '/../storage'),
            new JsonShoppingListFactory(new JsonShoppingItemFactory()),
        );
    }
}
