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
        $pathToStorage = __DIR__ . '/../../../../storage';
        $fileNames = scandir($pathToStorage);

        $listSlugs = [];

        foreach ($fileNames as $fileName) {
            if (str_ends_with($fileName, '.json')) {
//                $editedList = substr($shoppingList,0, strlen($shoppingList) - 5);
                $parts = explode('.', $fileName);
                $listSlugs[] = $parts[0];
            }
        }

        //$getListNames = new ShoppingListRepositoryInterface()


//        $enum = new ShoppingListFilterEnum($request->getFilterValue());
//
//        foreach ($listNames as $list) {
//            if ($enum->onlyNotArchived() && $list->isArchived() === false) {
//                $listNames[] = $list;
//            }
//        }
        return $listSlugs;
    }
}

