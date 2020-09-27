<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Dispatcher;

abstract class PrivateController extends Controller
{

	public function beforeExecuteRoute(Dispatcher $dispatcher)
    {
		// Executed before every found action
		$d = new DateTime(); 
		//var_dump("beforeExecuteRoute : " . $d->format('Y-m-d\TH:i:s.u'));
    }

    public function afterExecuteRoute(Dispatcher $dispatcher)
    {
		// Executed after every found action
		$d = new DateTime(); 
		//var_dump("afterExecuteRoute : " . $d->format('Y-m-d\TH:i:s.u'));
	}
	
	
	
}