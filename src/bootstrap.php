<?php

require __DIR__ . '/../vendor/autoload.php';

use \Statika\File\File;
use \Statika\Configuration\Application\JsonApplicationConfiguration;
use \Statika\File\Exception\FileNotFoundException;

$config = __DIR__ . DIRECTORY_SEPARATOR . '../conf/app.json';

if (!file_exists($config)) {
    throw new FileNotFoundException('Can´t find application configuration');
}

$configFile = new File($config);
$jsonConfig = new JsonApplicationConfiguration();
Statika\Statika::setConfig($jsonConfig->fromFile($configFile));
