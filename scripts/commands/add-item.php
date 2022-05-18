<?php

use Lindyhopchris\ShoppingList\Application\Commands\AddShoppingItem\AddShoppingItemModel;
use Lindyhopchris\ShoppingList\Common\Validation\ValidationException;
use Lindyhopchris\ShoppingList\Container;

/** @var array $args */

if (2 > count($args)) {
    echo 'Expecting two arguments: shopping list slug and item name.' . PHP_EOL;
    exit(1);
}

$command = Container::getInstance()->getAddShoppingItemCommand();
$model = new AddShoppingItemModel($args[0], $args[1]);

try {
    $command->execute($model);
} catch (ValidationException $ex) {
    echo 'Cannot add shopping item, for the following reason(s):' . PHP_EOL;
    foreach ($ex->getMessages() as $message) {
        echo $message . PHP_EOL;
    }
    exit(1);
}

echo sprintf(
    "Shopping item '%s' added to your '%s' list.",
    $model->getName(),
    $model->getList(),
) . PHP_EOL;
