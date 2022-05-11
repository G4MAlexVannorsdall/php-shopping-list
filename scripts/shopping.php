<?php

require_once __DIR__ . '/../vendor/autoload.php';

$args = $argv;
array_shift($args);

if (!isset($args[0])) {
    echo 'Expecting a command name as the first argument.' . PHP_EOL;
    exit(1);
}

$command = array_shift($args);
$filename = __DIR__ . '/commands/' . $command . '.php';

if (!file_exists($filename)) {
    echo sprintf('Unexpected command: "%s"', $command) . PHP_EOL;
    exit(1);
}

include $filename;

/**
 * This file is the App.php or equivalent. At the top it requires the autoloader to run once.
 *
 * It then gives the global variable args and uses the function array_shift to move a new item to the front of the array.
 *
 * Lines 8-11 is an error handling if statement that tells the computer what to show the user in the terminal if they are not
 * given the first argument [0].
 *
 * Line 13 assigns the command variable to array_shift($args) so that a new argument will be placed in the front of the array.
 *
 * Line 14 assigns the filename variable with the path to the commands.
 *
 * Lines 16-19 is an if statement that says if the file doesn't exist show the user in the terminal that the file
 * doesn't exist.
 *
 * Line 21 includes and evaluates a specific file.
 *
 */

