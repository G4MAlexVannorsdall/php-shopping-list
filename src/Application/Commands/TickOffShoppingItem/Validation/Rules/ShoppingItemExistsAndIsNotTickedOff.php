<?php
declare(strict_types=1);

namespace Lindyhopchris\ShoppingList\Application\Commands\TickOffShoppingItem\Validation\Rules;

use Lindyhopchris\ShoppingList\Application\Commands\TickOffShoppingItem\TickOffShoppingItemModel;
use Lindyhopchris\ShoppingList\Application\Commands\TickOffShoppingItem\Validation\TickOffShoppingItemRuleInterface;
use Lindyhopchris\ShoppingList\Common\Validation\ValidationMessageStack;
use Lindyhopchris\ShoppingList\Domain\ShoppingItemSelector;
use Lindyhopchris\ShoppingList\Persistance\ShoppingListRepositoryInterface;

class ShoppingItemExistsAndIsNotTickedOff implements TickOffShoppingItemRuleInterface
{
    /**
     * @var ShoppingListRepositoryInterface
     */
    private ShoppingListRepositoryInterface $repository;

    /**
     * ShoppingItemExistsAndIsNotTickedOff constructor.
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
    public function validate(TickOffShoppingItemModel $model): ValidationMessageStack
    {
        $result = new ValidationMessageStack();

        $list = $this->repository->find(
            $model->getList(),
        );

        if (null === $list) {
            $result->addMessage(sprintf(
                'Shopping list "%s" does not exist.',
                $model->getList(),
            ));
            return $result;
        }

        $item = $list->getItems()->select(
            new ShoppingItemSelector($model->getItem(), false),
        );

        if (null === $item) {
            $result->addMessage(sprintf(
                'Shopping item "%s" does not exist or is already marked as completed.',
                $model->getItem(),
            ));
        }

        return $result;
    }
}
