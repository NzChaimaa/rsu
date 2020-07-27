<?php

/** 
 * Set Config
 */
$di->set('config', $config);

/**
* Set Dispatcher
*/
$di->setShared(
    'dispatcher',
    function () {
        return include '../app/config/dispatcher.php';
    }
);

/**
* Configure routing system
*/
$di->setShared(
    'router',
    function () {
        return include '../app/config/router.php';
    }
);

/**
* Configure database
*/
$di->setShared(
    'db',
    function () use ($config) {
        return include '../app/config/database.php';
    }
);

/**
* Configure database
*/
$di->setShared(
    'request',
    function () {
        return new Core\Http\Request();
    }
);