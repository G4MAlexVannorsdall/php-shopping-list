<?php
declare(strict_types=1);

namespace Lindyhopchris\ShoppingList\Application\Commands\AddShoppingItem;

use Lindyhopchris\ShoppingList\Application\Commands\AddShoppingItem\Validation\AddShoppingItemValidator;
use Lindyhopchris\ShoppingList\Persistance\ShoppingListRepositoryInterface;

class AddShoppingItemCommand implements AddShoppingItemCommandInterface
{
    /**
     * @var AddShoppingItemValidator
     */
    private AddShoppingItemValidator $validator;

    /**
     * @var AddShoppingItemFactory
     */
    private AddShoppingItemFactory $factory;

    /**
     * @var ShoppingListRepositoryInterface
     */
    private ShoppingListRepositoryInterface $repository;

    /**
     * AddShoppingItemCommand constructor.
     *
     * @param AddShoppingItemValidator $validator
     * @param AddShoppingItemFactory $factory
     * @param ShoppingListRepositoryInterface $repository
     */
    public function __construct(
        AddShoppingItemValidator        $validator,
        AddShoppingItemFactory          $factory,
        ShoppingListRepositoryInterface $repository
    ) {
        $this->validator = $validator;
        $this->factory = $factory;
        $this->repository = $repository;
    }

    /**
     * @inheritDoc
     */
    public function execute(AddShoppingItemModel $model): void
    {
        $this->validator->validateOrFail($model);

        $list = $this->repository->findOrFail(
            $model->getList()
        );

        $item = $this->factory->make(
            $list->getItems(),
            $model->getName(),
        );

        $list->addItem($item);

        $this->repository->store($list);
    }
}
