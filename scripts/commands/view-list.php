<?php

/** @var array $args */

use Lindyhopchris\ShoppingList\Container;
use Lindyhopchris\ShoppingList\Persistance\ShoppingListNotFoundException;
use Lindyhopchris\ShoppingList\Domain\ValueObjects\ShoppingItemFilterEnum;

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
/**
 * Lines 5-6 import files with logic that can be used in this file.
 *
 * Line 5 imports the container that has the object and has the means to retrieve it.
 *
 * Line 6 imports the ShoppingListNotFoundException class.
 *
 * Lines 8-11 is an if statement that says if 1 is greater than the number of arguments an error message will be
 * shown on the terminal.
 *
 * Line 13 assigns the variable slug to the first argument given in the terminal.
 *
 * Line 14 assigns the query variable to the static Container class that calls on the getInstance function that calls
 * on the getShoppingListDetailQuery function.
 *
 * Lines 16-21 is a try and catch block. The list variable is calling on the query variable that calls on the
 * execute function that is passing in the slug variable.
 * In the catch section the ShoppingListNotFoundException class is called with the variable ex to validate the given information.
 * It then echoes a statement that tells the user that their list doesn't exist with the slug variable and then exits
 * the loop.
 *
 * Lines 23-29 is an if statement that passes in the variables list that calls on the isEmpty function. It then echoes
 * a statement to the terminal using the sprintf function saying that the list has no items. Then it calls on the list
 * variable which calls on the getName function and then exits the loop.
 *
 * Line 31 uses the sprintf function to echo to the terminal the items that were inputted in the terminal if the
 * script was successful. The list variable then calls on the getName function, then the list variable calls on the count
 * function.
 *
 * Lines 33-40 is a foreach loop that passes in the list variable that calls on the getItems function as item. It then
 * echoes to the terminal using the sprintf function the id, complete (being ticked off or not), and the name of the item.
 *
 */
