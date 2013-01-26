<?php
use simtpl\application;
use simtpl\exception;

require_once(dirname(__FILE__) . "/source/application.php");

try {
	$application = application::getInstance(dirname(__FILE__) . "/config/config.xml");
	$application->init();
	$handler_factory = $application->getHandlerFactory();
	$handler = $handler_factory->getHandler();
	$handler->handle();
} catch(exception\auth $e) {
	// your behavior for incorrect auth (both ajax and general, all custom exceptions should provide basic information about current enviroment)
} catch(exception\nopage $e) {
	// your behavior for URL without template/Forbidden URL etc
} catch(\Exception $e) {
	// default Exception handler
	echo $e->getMessage();
}