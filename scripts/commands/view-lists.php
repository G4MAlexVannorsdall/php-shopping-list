<?php

/** @var array $args */

use Lindyhopchris\ShoppingList\Application\Queries\GetShoppingListNames\GetShoppingListNamesRequest;
use Lindyhopchris\ShoppingList\Container;

$query = Container::getInstance()->getShoppingListNamesQuery();
$listNames = $query->execute(new GetShoppingListNamesRequest());

print_r($listNames);

