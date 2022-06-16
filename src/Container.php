<?php
declare(strict_types=1);

namespace Lindyhopchris\ShoppingList;

use Lindyhopchris\ShoppingList\Application\Commands\AddShoppingItem\AddShoppingItemCommand;
use Lindyhopchris\ShoppingList\Application\Commands\AddShoppingItem\AddShoppingItemCommandInterface;
use Lindyhopchris\ShoppingList\Application\Commands\AddShoppingItem\AddShoppingItemFactory;
use Lindyhopchris\ShoppingList\Application\Commands\AddShoppingItem\Validation\AddShoppingItemValidator;
use Lindyhopchris\ShoppingList\Application\Commands\AddShoppingItem\Validation\Rules as AddShoppingItemRules;
use Lindyhopchris\ShoppingList\Application\Commands\ArchiveShoppingList\ArchiveShoppingListCommand;
use Lindyhopchris\ShoppingList\Application\Commands\ArchiveShoppingList\ArchiveShoppingListCommandInterface;
use Lindyhopchris\ShoppingList\Application\Commands\CreateShoppingList\CreateShoppingListCommand;
use Lindyhopchris\ShoppingList\Application\Commands\CreateShoppingList\CreateShoppingListCommandInterface;
use Lindyhopchris\ShoppingList\Application\Commands\CreateShoppingList\CreateShoppingListFactory;
use Lindyhopchris\ShoppingList\Application\Commands\CreateShoppingList\Validation\CreateShoppingListValidator;
use Lindyhopchris\ShoppingList\Application\Commands\CreateShoppingList\Validation\Rules as CreateShoppingListRules;
use Lindyhopchris\ShoppingList\Application\Commands\TickOffShoppingItem\TickOffShoppingItemCommand;
use Lindyhopchris\ShoppingList\Application\Commands\TickOffShoppingItem\TickOffShoppingItemCommandInterface;
use Lindyhopchris\ShoppingList\Application\Commands\TickOffShoppingItem\Validation\Rules as TickOffShoppingItemRules;
use Lindyhopchris\ShoppingList\Application\Commands\TickOffShoppingItem\Validation\TickOffShoppingItemValidator;
use Lindyhopchris\ShoppingList\Application\Queries\GetShoppingListDetail\GetShoppingListDetailQuery;
use Lindyhopchris\ShoppingList\Application\Queries\GetShoppingListDetail\GetShoppingListDetailQueryInterface;
use Lindyhopchris\ShoppingList\Persistance\Json\JsonFileHandler;
use Lindyhopchris\ShoppingList\Persistance\Json\JsonShoppingItemFactory;
use Lindyhopchris\ShoppingList\Persistance\Json\JsonShoppingListFactory;
use Lindyhopchris\ShoppingList\Persistance\Json\JsonShoppingListRepository;
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
     * Get an add shopping item command instance.
     *
     * @return AddShoppingItemCommandInterface
     */
    public function getAddShoppingItemCommand(): AddShoppingItemCommandInterface
    {
        $repository = $this->getShoppingListRepository();

        $validator = new AddShoppingItemValidator(
            new AddShoppingItemRules\ShoppingListExists($repository),
            new AddShoppingItemRules\ShoppingItemNameIsNotEmpty(),
        );

        return new AddShoppingItemCommand(
            $validator,
            new AddShoppingItemFactory(),
            $repository,
        );
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
            new CreateShoppingListRules\ShoppingListSlugMatchesPattern(),
            new CreateShoppingListRules\ShoppingListSlugMustBeUnique($repository),
            new CreateShoppingListRules\ShoppingListNameIsNotEmpty(),
        );

        return new CreateShoppingListCommand(
            $validator,
            new CreateShoppingListFactory(),
            $repository,
        );
    }

    /**
     * Get a shopping list detail query instance.
     *
     * @return GetShoppingListDetailQueryInterface
     */
    public function getShoppingListDetailQuery(): GetShoppingListDetailQueryInterface
    {
        return new GetShoppingListDetailQuery(
            $this->getShoppingListRepository(),
        );
    }

    /**
     * Get a tick-off shopping item command instance.
     *
     * @return TickOffShoppingItemCommandInterface
     */
    public function getTickOffShoppingItemCommand(): TickOffShoppingItemCommandInterface
    {
        $repository = $this->getShoppingListRepository();

        $validator = new TickOffShoppingItemValidator(
            new TickOffShoppingItemRules\ShoppingItemExistsAndIsNotTickedOff($repository),
        );

        return new TickOffShoppingItemCommand(
            $validator,
            $repository,
        );
    }

    /**
     * Get an archived shopping list command instance
     *
     * @return ArchiveShoppingListCommandInterface
     */
    public function getArchiveShoppingListCommand(): ArchiveShoppingListCommandInterface
    {
        $repository = $this->getShoppingListRepository();

        return new ArchiveShoppingListCommand($repository);
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
