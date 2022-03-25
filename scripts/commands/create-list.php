<?php

use Lindyhopchris\ShoppingList\Application\Commands\CreateShoppingList\CreateShoppingListException;
use Lindyhopchris\ShoppingList\Application\Commands\CreateShoppingList\CreateShoppingListModel;
use Lindyhopchris\ShoppingList\Container;

/** @var array $args */

if (2 > count($args)) {
    echo 'Expecting two arguments: shopping list slug and name.' . PHP_EOL;
    exit(1);
}

$command = Container::getInstance()->getCreateShoppingListCommand();
$model = new CreateShoppingListModel($args[0], $args[1]);

try {
    $command->execute($model);
} catch (CreateShoppingListException $ex) {
    echo 'Failed to create shopping list, for the following reason(s):' . PHP_EOL;
    foreach ($ex->getMessages() as $message) {
        echo $message . PHP_EOL;
    }
    exit(1);
}

echo "Shopping list '{$model->getName()}' created!" . PHP_EOL;
echo "Use '{$model->getSlug()}' when executing commands for this list." . PHP_EOL;
