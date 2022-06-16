<?php

/** @var array $args */

use Lindyhopchris\ShoppingList\Application\Commands\ArchiveShoppingList\ArchiveShoppingListModel;
use Lindyhopchris\ShoppingList\Common\Validation\ValidationException;
use Lindyhopchris\ShoppingList\Container;

if (1 > count($args)) {
    echo 'Expecting one argument: shopping list slug.' . PHP_EOL;
    exit(1);
}

$command = Container::getInstance()->getArchiveShoppingListCommand();
$model = new ArchiveShoppingListModel($args[0]);

try {
    $command->execute($model);
} catch (ValidationException $ex) {
    echo 'Cannot mark shopping list as archived, for the following reason(s):' . PHP_EOL;
    foreach ($ex->getMessages() as $message) {
        echo $message . PHP_EOL;
    }
    exit(1);
}

echo sprintf(
    "Shopping list '%s' has been archived.",
    $model->getList(),
) . PHP_EOL;
