<?php
declare(strict_types=1);

namespace Lindyhopchris\ShoppingList\Application\Queries\GetShoppingListDetail;

use Lindyhopchris\ShoppingList\Domain\ShoppingItem;
use Lindyhopchris\ShoppingList\Domain\ValueObjects\ShoppingItemFilterEnum;
use Lindyhopchris\ShoppingList\Persistance\ShoppingListRepositoryInterface;

class GetShoppingListDetailQuery implements GetShoppingListDetailQueryInterface
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
    public function execute(GetShoppingListDetailRequest $request): ShoppingListDetailModel
    {
        $list = $this->repository->findOrFail($request->getSlug());
        $items = [];

        $enum = new ShoppingItemFilterEnum($request->getFilterValue());

        /** @var ShoppingItem $item */
        foreach ($list->getItems() as $item) {
            if (($enum->onlyNotCompleted() && $item->isNotCompleted()) ||
                $enum->all() ||
                ($enum->onlyCompleted() && $item->isCompleted())
            ) {
                $items[] = new ShoppingItemDetailModel(
                    $item->getId(),
                    $item->getName(),
                    $item->isCompleted(),
                );
            }
        }

        return new ShoppingListDetailModel(
            $list->getSlug()->toString(),
            $list->getName(),
            $items,
        );
    }
}
