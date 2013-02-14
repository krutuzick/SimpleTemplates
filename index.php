<?php
use simtpl\application;
use simtpl\exceptions;

require_once(dirname(__FILE__) . "/source/application.php");

try {
	$application = new application(dirname(__FILE__) . "/config/config.xml");
	$handler_factory = $application->getHandlerFactory();
	$handler = $handler_factory->getHandler();
	echo $handler->handle();
} catch(exceptions\base $e) {
	// default Exception handler for customized exceptions
	echo "<pre>{$e->getFancyMessage()}</pre>";
} catch(\Exception $e) {
	// default Exception handler
	echo "<pre>{$e->getMessage()}</pre>";
}

/**
 * System requirements:
 * php > 5.3.7
 */