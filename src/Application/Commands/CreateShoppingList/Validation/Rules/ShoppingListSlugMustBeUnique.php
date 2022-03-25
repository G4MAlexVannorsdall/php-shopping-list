<?php
declare(strict_types=1);

namespace Lindyhopchris\ShoppingList\Application\Commands\CreateShoppingList\Validation\Rules;

use Lindyhopchris\ShoppingList\Application\Commands\CreateShoppingList\CreateShoppingListModel;
use Lindyhopchris\ShoppingList\Application\Commands\CreateShoppingList\Validation\CreateShoppingListRuleInterface;
use Lindyhopchris\ShoppingList\Common\Validation\ValidationMessageStack;
use Lindyhopchris\ShoppingList\Persistance\ShoppingListRepositoryInterface;

class ShoppingListSlugMustBeUnique implements CreateShoppingListRuleInterface
{
    /**
     * @var ShoppingListRepositoryInterface
     */
    private ShoppingListRepositoryInterface $repository;

    /**
     * ShoppingListSlugMustBeUnique constructor.
     *
     * @param ShoppingListRepositoryInterface $repository
     */
    public function __construct(ShoppingListRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @inheritDoc
     */
    public function validate(CreateShoppingListModel $model): ValidationMessageStack
    {
        $result = new ValidationMessageStack();

        if ($this->repository->exists($model->getSlug())) {
            $result->addMessage(sprintf(
                'Shopping list "%s" already exists.',
                $model->getSlug(),
            ));
        }

        return $result;
    }
}
