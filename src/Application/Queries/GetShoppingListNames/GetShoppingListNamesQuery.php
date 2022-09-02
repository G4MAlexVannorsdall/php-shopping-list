<?php
declare(strict_types=1);

namespace Lindyhopchris\ShoppingList\Application\Queries\GetShoppingListNames;

use Lindyhopchris\ShoppingList\Domain\ValueObjects\ShoppingListFilterEnum;
use Lindyhopchris\ShoppingList\Persistance\ShoppingListRepositoryInterface;

class GetShoppingListNamesQuery implements GetShoppingListNamesQueryInterface
{
    /**
     * @var ShoppingListRepositoryInterface
     */
    private ShoppingListRepositoryInterface $repository;

    /**
     * @param ShoppingListRepositoryInterface $repository
     */
    public function __construct(ShoppingListRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @inheritDoc
     */
    public function execute(GetShoppingListNamesRequest $request): array
    {
        $pathToStorage = '../../storage';
        $shoppingLists = scandir($pathToStorage);

        $viewLists = [];

        foreach ($shoppingLists as $shoppingList) {
            if (str_ends_with($shoppingList, '.json')) {
                $editedList = substr($shoppingList, -5);
                $viewLists[] = $editedList;
            }

            return $viewLists;
        }

        $enum = new ShoppingListFilterEnum($request->getFilterValue());

        foreach ($viewLists as $list) {
            if ($enum->onlyNotArchived() && $list->isArchived() === false) {
                $listNames[] = new ShoppingListNamesModel(
                    $list->getSlug()->toString(),
                    $list->getName()
                );
            }
        }
        return $listNames;
    }
}

