<?php

use Lindyhopchris\ShoppingList\Application\Commands\DeleteShoppingList\DeleteShoppingListModel;
use Lindyhopchris\ShoppingList\Container;
use Lindyhopchris\ShoppingList\Persistance\ShoppingListRepositoryInterface;
use Lindyhopchris\ShoppingList\Persistance\ShoppingListNotFoundException;

/** @var array $args */
if (1 > count($args)) {
    echo 'Expecting one arguments: shopping list slug.' . PHP_EOL;
    exit(1);
}

$command = Container::getInstance()->getDeleteShoppingListCommand();
$model = new DeleteShoppingListModel($args[0]);

try {
     $command->execute($model);
} catch (ShoppingListNotFoundException) {
    echo sprintf("Shopping list '%s' does not exist.", $args[0]) . PHP_EOL;
    exit(1);
}

echo "Shopping list '{$model->getList()}' deleted!" . PHP_EOL;


