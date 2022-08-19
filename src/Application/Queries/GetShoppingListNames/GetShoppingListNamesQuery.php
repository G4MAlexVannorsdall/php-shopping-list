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
        $list = $this->repository->findOrFail($request->getSlug());
        $newList = [];

        $enum = new ShoppingListFilterEnum($request->getFilterValue());

        while ($list->getName()) {
            if ($enum->onlyNotArchived() && $list->isArchived() === false) {
                $newList[] = new ShoppingListNamesModel(
                    $list->getSlug()->toString(),
                    $list->getName()
                );
            }
        }
        return $newList;
    }
}
