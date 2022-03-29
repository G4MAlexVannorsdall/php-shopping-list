<?php
declare(strict_types=1);

namespace Lindyhopchris\ShoppingList\Application\Queries\GetShoppingListDetail;

use Lindyhopchris\ShoppingList\Domain\ShoppingItem;
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
    public function execute(string $slug): ShoppingListDetailModel
    {
        $list = $this->repository->findOrFail($slug);

        $items = array_map(static fn(ShoppingItem $item): ShoppingItemDetailModel => new ShoppingItemDetailModel(
            $item->getId(),
            $item->getName(),
            $item->isCompleted(),
        ), $list->getItems()->all());

        return new ShoppingListDetailModel(
            $list->getSlug()->toString(),
            $list->getName(),
            $items,
        );
    }
}
