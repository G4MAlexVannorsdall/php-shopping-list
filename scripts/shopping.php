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


