<?php
namespace simtpl\interfaces;

interface Ihandler_factory {
	/**
	 * @return \simtpl\handlers\base
	 */
	public function getHandler();
}

?>