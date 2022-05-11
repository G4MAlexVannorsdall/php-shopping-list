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

/**
 * Lines 3-5 are import statements so that logic in those files can be used in this file.
 *
 * Line 3 is the model for this script file.
 *
 * Line 4 is the validation exception file to check if the information given is valid.
 *
 * Line 5 is the container that holds the object and has the means to retrieve them.
 *
 * Lines 9-12 is an if statement that says if 2 is greater than the number of arguments an error message will be
 * show on the terminal.
 *
 * Line 14 assigns the command variable to the static container function calling on the getInstance function that calls
 * on the getAddShoppingItemCommand function.
 *
 * Line 15 assigns the model variable to a new object of AddShoppingItemModel with two parameters or arguments.
 *
 * Lines 17-25 is a try catch block. The command variable is calling the execute function that passes in the model variable.
 * It catches errors by calling on the class ValidationException and gives a variable ex. Then it echoes out a statement
 * to the terminal.
 * A foreach loop uses the ex variable that calls on the getMessages function as the message variable and then echoes
 * the message before exiting the loop.
 *
 * Lines 27-31 uses the sprintf function to echo a statement to the terminal if the script was successful, then the model variable
 * calls on the getName function, and on line 30 the model variable calls on the getList function.
 */
