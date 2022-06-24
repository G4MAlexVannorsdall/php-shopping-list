<?php
declare(strict_types=1);

namespace Lindyhopchris\ShoppingList\Application\Commands\TickOffShoppingItem;

use Lindyhopchris\ShoppingList\Application\Commands\TickOffShoppingItem\Validation\TickOffShoppingItemValidator;
use Lindyhopchris\ShoppingList\Domain\ShoppingItemSelector;
use Lindyhopchris\ShoppingList\Persistance\ShoppingListRepositoryInterface;

class TickOffShoppingItemCommand implements TickOffShoppingItemCommandInterface
{
    /**
     * @var TickOffShoppingItemValidator
     */
    private TickOffShoppingItemValidator $validator;

    /**
     * @var ShoppingListRepositoryInterface
     */
    private ShoppingListRepositoryInterface $repository;

    /**
     * TickOffShoppingItemCommand constructor.
     *
     * @param TickOffShoppingItemValidator $validator
     * @param ShoppingListRepositoryInterface $repository
     */
    public function __construct(TickOffShoppingItemValidator $validator, ShoppingListRepositoryInterface $repository)
    {
        $this->validator = $validator;
        $this->repository = $repository;
    }

    /**
     * @inheritDoc
     */
    public function execute(TickOffShoppingItemModel $model): void
    {
        $this->validator->validateOrFail($model);

        $list = $this->repository->findOrFail(
            $model->getList(),
        );

        $item = $list->getItems()->select(
            new ShoppingItemSelector($model->getItem(), false),
        );

        $item->markAsCompleted();

        $items = [];
        foreach ($items as $item) {
            if ($item->isCompleted() === true) {
                $items[] = $item;
            }
        }
            if ($list->getItems() == 0) {
                $list->setArchived(true);
            }

            $this->repository->store($list);
        }
}
