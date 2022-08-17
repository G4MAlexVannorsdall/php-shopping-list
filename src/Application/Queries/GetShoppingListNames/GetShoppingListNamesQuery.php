<?php
declare(strict_types=1);

namespace Lindyhopchris\ShoppingList\Application\Queries\GetShoppingListNames;

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
    public function execute(GetShoppingListNamesRequest $request): ShoppingListNamesModel
    {
        //$archived = $request->getFilterValue();

        $storageDirectory = 'storage';
        $lists = array_diff(scandir($storageDirectory), array('.', '..'));




        print_r($lists);

        return;
    }
}
