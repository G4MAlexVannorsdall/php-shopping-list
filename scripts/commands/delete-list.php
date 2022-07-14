<?php

use Lindyhopchris\ShoppingList\Application\Commands\DeleteShoppingList\DeleteShoppingListModel;
use Lindyhopchris\ShoppingList\Container;

/** @var array $args */
if (1 > count($args)) {
    echo 'Expecting one arguments: shopping list slug.' . PHP_EOL;
    exit(1);
}

$command = Container::getInstance()->getDeleteShoppingListCommand();
$model = new DeleteShoppingListModel($args[0]);

$command->execute($model);

echo "Shopping list '{$model->getList()}' deleted!" . PHP_EOL;


