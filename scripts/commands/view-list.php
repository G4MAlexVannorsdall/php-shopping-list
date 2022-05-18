<?php

/** @var array $args */

use Lindyhopchris\ShoppingList\Container;
use Lindyhopchris\ShoppingList\Persistance\ShoppingListNotFoundException;

if (1 > count($args)) {
    echo 'Expecting one argument: shopping list slug.' . PHP_EOL;
    exit(1);
}

$slug = $args[0];
$query = Container::getInstance()->getShoppingListDetailQuery();

try {
    $list = $query->execute($slug);
} catch (ShoppingListNotFoundException $ex) {
    echo sprintf("Shopping list '%s' does not exist.", $slug) . PHP_EOL;
    exit(1);
}

if ($list->isEmpty()) {
    echo sprintf(
        "Shopping list '%s' has no items.",
        $list->getName(),
    ) . PHP_EOL;
    exit(0);
}

echo sprintf('%s (%d items):', $list->getName(), $list->count()) . PHP_EOL;

foreach ($list->getItems() as $item) {
    echo sprintf(
        "%s. [%s] %s",
        $item->getId(),
        $item->isCompleted() ? 'X' : ' ',
        $item->getName(),
    ) . PHP_EOL;
}

