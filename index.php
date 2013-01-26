<?php
use simtpl\application;
use simtpl\exceptions;

require_once(dirname(__FILE__) . "/source/application.php");

try {
	$application = application::getInstance(dirname(__FILE__) . "/config/config.xml");
	$handler_factory = $application->getHandlerFactory();
	$handler = $handler_factory->getHandler();
	echo $handler->handle();
} catch(exceptions\base $e) {
	// default Exception handler for customized exceptions
	echo $e->getFancyMessage();
} catch(\Exception $e) {
	// default Exception handler
	echo $e->getMessage();
}

/**
 * System requirements:
 * php > 5.3.7
 */