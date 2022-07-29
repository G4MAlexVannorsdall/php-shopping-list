<?php

use Lindyhopchris\ShoppingList\Application\Commands\DeleteShoppingItem\DeleteShoppingItemModel;
use Lindyhopchris\ShoppingList\Common\Validation\ValidationException;
use Lindyhopchris\ShoppingList\Container;

/** @var array $args */

if (2 > count($args)) {
    echo 'Expecting two arguments: shopping list slug and item name.' . PHP_EOL;
    exit(1);
}

$command = Container::getInstance()->getDeleteShoppingItemCommand();
$model = new DeleteShoppingItemModel($args[0], $args[1]);

try {
    $command->execute($model);
} catch (ValidationException $ex) {
    echo 'Cannot delete shopping item, for the following reason(s):' . PHP_EOL;
    foreach ($ex->getMessages() as $message) {
        echo $message . PHP_EOL;
    }
    exit(1);
}

echo sprintf(
        "Shopping item '%s' deleted off your '%s' list.",
        $model->getList(),
        $model->getItem(),
    ) . PHP_EOL;
