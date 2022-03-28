<?php
declare(strict_types=1);

namespace Lindyhopchris\ShoppingList\Application\Commands\CreateShoppingList;

use Lindyhopchris\ShoppingList\Application\Commands\CreateShoppingList\Validation\CreateShoppingListValidator;
use Lindyhopchris\ShoppingList\Persistance\ShoppingListRepositoryInterface;

class CreateShoppingListCommand implements CreateShoppingListCommandInterface
{
    /**
     * @var CreateShoppingListValidator
     */
    private CreateShoppingListValidator $validator;

    /**
     * @var CreateShoppingListFactory
     */
    private CreateShoppingListFactory $factory;

    /**
     * @var ShoppingListRepositoryInterface
     */
    private ShoppingListRepositoryInterface $repository;

    /**
     * @param CreateShoppingListValidator $validator
     * @param CreateShoppingListFactory $factory
     * @param ShoppingListRepositoryInterface $repository
     */
    public function __construct(
        CreateShoppingListValidator     $validator,
        CreateShoppingListFactory       $factory,
        ShoppingListRepositoryInterface $repository
    ) {
        $this->validator = $validator;
        $this->factory = $factory;
        $this->repository = $repository;
    }

    /**
     * @inheritDoc
     */
    public function execute(CreateShoppingListModel $model): void
    {
        $this->validator->validateOrFail($model);

        $entity = $this->factory->make(
            $model->getSlug(),
            $model->getName(),
        );

        $this->repository->store($entity);
    }
}
