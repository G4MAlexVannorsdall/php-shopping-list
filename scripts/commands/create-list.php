<?php

use Lindyhopchris\ShoppingList\Application\Commands\CreateShoppingList\CreateShoppingListModel;
use Lindyhopchris\ShoppingList\Common\Validation\ValidationException;
use Lindyhopchris\ShoppingList\Container;

/** @var array $args */

if (2 > count($args)) {
    echo 'Expecting two arguments: shopping list slug and name.' . PHP_EOL;
    exit(1);
}

$command = Container::getInstance()->getCreateShoppingListCommand();
$model = new CreateShoppingListModel($args[0], $args[1]);

try {
    $command->execute($model);
} catch (ValidationException $ex) {
    echo 'Cannot create shopping list, for the following reason(s):' . PHP_EOL;
    foreach ($ex->getMessages() as $message) {
        echo $message . PHP_EOL;
    }
    exit(1);
}

echo "Shopping list '{$model->getName()}' created!" . PHP_EOL;
echo "Use '{$model->getSlug()}' when executing commands for this list." . PHP_EOL;

/**
 * Lines 3-5 are import statements to use logic from those files in this script file.
 *
 * Line 3 imports the modal for this script file.
 *
 * Line 4 imports the validation exceptions that can show up if something is not valid.
 *
 * Line 5 imports the container that contains the objects and the means to retrieve them.
 *
 * Lines 9-12 is an if statement that says if 2 is greater than the number of arguments an error message will be
 * show on the terminal
 *
 * Line 14 assigns the command variable to the static function getInstance in the container and calls on the
 * getCreateShoppingListCommand function.
 *
 * Line 15 assigns the model variable to a new CreateShoppingListModel object with two parameters or arguments.
 *
 * Lines 17-25 is a try catch block that the command variable calls on the execute function that passes in the model variable.
 * The catch of the try catch block, passes in the ValidationException class with the variable ex. It echoes a message
 * to the terminal.
 * Then a foreach loop passes in the ex variable that calls on the getMessages function as a message and echoes message
 * before exiting the loop.
 *
 * Line 27 echoes a statement when a shopping list has been created using the object syntax {{$model->getName()}}
 *
 * Line 28 echoes a statement telling the user what to type in or what they are missing object syntax {$model->getSlug()}
 *
 *
 */
