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

/**
 * Lines 3-5 are import statements so the logic in those files can be used in this file.
 *
 * Line 3 imports the model for ticking an item off.
 *
 * Line 4 imports the validation file to validate the information given.
 *
 * Line 5 imports the container that contains the objects and the means to retrieve them.
 *
 * Lines 9-12 is an if statement that says if 2 is greater than the number of arguments an error message will be
 * show on the terminal.
 *
 * Line 14 the variable command is assigned to the static container class that is calling on the getInstance function that
 * is calling on the getTickOffShoppingItemCommand function.
 *
 * Line 15 the variable model is assigned to a new object of type TickOffShoppingItemModel that has two arguments.
 *
 * Lines 17-25 is a try and catch block. The command variable is calling on the execute function that is passing in the model
 * variable.
 * In the catch section the ValidationException class is called with the variable ex to validate the given information.
 * It then echoes a statement that tells the user that their item can't be marked off for a certain reason.
 * A foreach loop is next that has the ex variable calling on the getMessages function as message variable, then echoes
 * the message before exiting the loop.
 *
 * Lines 27-31 uses the sprintf function to echo a statement to the terminal if the script was successful, then the model variable
 * calls on the getName function, and on line 30 the model variable calls on the getList function.
 */
