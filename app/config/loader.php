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
        //j'ai ajoutée la ligne de Models et controllers
        // 'App\Models' => realpath('..') . '/app/models/' ,
        // 'App\Controllers' => realpath('..') . '/app/controllers/',
       'Core\Db' => realpath('..') . '/app/core/db',
       'Core\Http' => realpath('..') . '/app/core/http',
       'Core\Middleware' => realpath('..') . '/app/core/middleware',
    ]
);

$loader->register();
