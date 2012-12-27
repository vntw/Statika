<?php

require __DIR__ . '/../vendor/autoload.php';

// Load application config
include __DIR__ . DIRECTORY_SEPARATOR . 'config.php';

if (!($config instanceof Statika\Configuration\Application\ApplicationConfiguration)) {
    die('The config.php has to return an instance of Statika\Configuration\Application\ApplicationConfiguration!' . PHP_EOL);
}

Statika\Statika::setConfig($config);
