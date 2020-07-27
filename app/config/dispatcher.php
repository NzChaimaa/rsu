<?php


use Phalcon\Events\Manager;
use Phalcon\Mvc\Dispatcher;

$dispatcher = new Dispatcher();

$eventsManager = new Manager();

$eventsManager->attach("dispatch:beforeDispatchLoop", 
        function($event, $dispatcher) 
        {

            $keyParams = array();
            $params = $dispatcher->getParams();

            //Use odd parameters as keys and even as values
            foreach ($params as $number => $value) {
                if ($number & 1) {
                    $keyParams[$params[$number - 1]] = $value;
                }
            }
            //Override parameters
            $dispatcher->setParams($keyParams);
        });
           
$dispatcher->setEventsManager($eventsManager);      
return $dispatcher;