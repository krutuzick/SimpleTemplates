<?php
namespace simtpl\interfaces;

interface Ihandler_factory {
	public function getHandler();
	public static function getInstance($configuration);
}

?>