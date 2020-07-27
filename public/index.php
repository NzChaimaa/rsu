<?php


require_once '../app/config/headers.php';

use Phalcon\Di;

error_reporting(E_ALL);
//error_reporting(0);


/**
 * Creationg a dependency injector object
*/
$di = new Di();

/**
 * Loading configuration data
*/
require_once '../app/config/config.php';
$config = new Phalcon\Config($settings);

/**
* Read auto-loader
*/
require_once '../app/config/loader.php';

/**
* Register services to $di
*/
require_once '../app/config/services.php';

/**
 * init third party plugins
*/
require_once '../app/config/plugins.php';

try {

    $di->get('dispatcher')->setControllerName($di->get('router')->getControllerName());
    $di->get('dispatcher')->setActionName($di->get('router')->getActionName());
    $di->get('dispatcher')->dispatch();

    $response = new Core\Http\Response();
    $response =  $di->get('dispatcher')->getReturnedValue();
    $response->send();

} catch (Exception $e) {
 
    $response_data = [
            'code'      => $e->getCode(),
            'message'   => $e->getMessage(),
            'file'      => $e->getFile(),
            'line'      => $e->getLine(),
            'trace'     => $e->getTraceAsString(),
    ];
    $response = new Core\Http\Response();
    $response->setContent(json_encode($response_data));
    return $response;
}

