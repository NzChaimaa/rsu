<?php

use Phalcon\Mvc\Router;

$router = new Router();

$router->setDefaultController('index')->setDefaultAction('index');

$router->add("/", array(
        'controller' => 'index',
        'action'     => 'index'
    ));

$router->add("/:controller", array(
        'controller' => 1,
        'action'     => 'index'
));
                       
$router->add("/:controller/:action", array(
        'controller' => 1,
        'action'     => 2
));
            
$router->add("/:controller/:action/:params", array(
        'controller' => 1,
        'action'     => 2,
        'params'     => 3
 ));

$router->handle($_GET['_url']);

return $router;



