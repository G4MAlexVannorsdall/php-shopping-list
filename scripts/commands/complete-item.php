<?php

use Lindyhopchris\ShoppingList\Application\Commands\TickOffShoppingItem\TickOffShoppingItemModel;
use Lindyhopchris\ShoppingList\Common\Validation\ValidationException;
use Lindyhopchris\ShoppingList\Container;

/** @var array $args */

if (2 > count($args)) {
    echo 'Expecting two arguments: shopping list slug and item name.' . PHP_EOL;
    exit(1);
}

$command = Container::getInstance()->getTickOffShoppingItemCommand();
$model = new TickOffShoppingItemModel($args[0], $args[1]);

try {
    $command->execute($model);
} catch (ValidationException $ex) {
    echo 'Cannot mark shopping item as completed, for the following reason(s):' . PHP_EOL;
    foreach ($ex->getMessages() as $message) {
        echo $message . PHP_EOL;
    }
    exit(1);
}

echo sprintf(
    "Shopping item '%s' marked as completed on your '%s' list.",
    $model->getItem(),
    $model->getList(),
) . PHP_EOL;
