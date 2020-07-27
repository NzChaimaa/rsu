<?php

use Phalcon\Loader;

require '../app/vendor/autoload.php';

$loader = new Loader();

$loader->registerDirs(
    [
        realpath('..') . '/app/controllers/',
        realpath('..') . '/app/models/',
    ]
);

$loader->registerNamespaces(
    [
       'Core\Db' => realpath('..') . '/app/core/db',
       'Core\Http' => realpath('..') . '/app/core/http',
       'Core\Middleware' => realpath('..') . '/app/core/middleware',
    ]
);

$loader->register();
