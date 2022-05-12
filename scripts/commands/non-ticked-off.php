<?php
/**
 * The purpose of this script is to view the list with ONLY the items that have not been ticked off.
 */

use Lindyhopchris\ShoppingList\Container;
use Lindyhopchris\ShoppingList\Persistance\ShoppingListNotFoundException;

$args = $argv;

if (1 > count($args)) {
    echo 'Expecting one argument: shopping list slug.' . PHP_EOL;
    exit(1);
}

$slug = $args[2];
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
    if (!$item->isCompleted()) {
        echo sprintf(
                "%s. [%s] %s",
                $item->getId(),
                $item->isCompleted(),
                $item->getName(),
            ) . PHP_EOL;
    }
}

/**
 * Lines 6-7 are import statements that contain logic that we can use in this file.
 *
 * Line 6 imports the container that holds the object and the means of retrieving it.
 *
 * Line 7 imports the ShoppingListNotFoundException class that handles exceptions if they occur.
 *
 * Line 9 sets the global variable.
 *
 * Lines 11-14 is an if statement that says if 1 is greater than the number of arguments an error message will be
 * show on the terminal.
 *
 * Line 16 assigns the variable slug to the second argument in the terminal.
 *
 * Line 17 assigns the variable query to the static container class that contains the getInstance function that is
 * calling on the getShoppingListDetailQuery function.
 *
 * Lines 19-24  is a try and catch block. The list variable is calling on the query variable that calls on the
 * execute function that is passing in the slug variable.
 * In the catch section the ShoppingListNotFoundException class is called with the variable ex to validate the given information.
 * It then echoes a statement that tells the user that their list doesn't exist with the slug variable and then exits
 * the loop.
 *
 * Lines 26-32 is an if statement that is passing in the variable list that is calling on the function isEmpty. Then
 * echoing a message to the terminal telling the user that there are no items on the list. It then uses the list variable
 * to call on the getName function.
 *
 * Line 34 uses the sprintf function to echo to the terminal the items that were inputted in the terminal if the
 * script was successful. The list variable then calls on the getName function, then the list variable calls on the count
 * function.
 *
 * Lines 36-45 is a foreach statement that passes in the variable list that calls on the function getItems as items.
 * Then there is an if statement that says if the variable item that is calling on getCompleted is not ticked off, show
 * it in the terminal. It then uses the item variable to call on the getId function, getCompleted function, and getName
 * function.
 */
