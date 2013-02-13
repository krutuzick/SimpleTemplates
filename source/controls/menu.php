<?php
namespace simtpl\controls;
use simtpl\exceptions;

/**
 * @todo phpDoc
 */
class menu extends base {

	protected $structure = array();
	protected $current_page;
	protected $brand;
	protected $separators = false;
	protected $inverted_color = false;

	public function __construct(&$structure, &$current_page) {
		if(is_array($structure)) {
			$this->structure = $structure;
		} elseif($structure instanceof \simtpl\page) {
			$this->structure = array($structure);
		} else {
			throw new exceptions\source("Incorrect parameter 'structure' for control 'menu'");
		}
		if($current_page instanceof \simtpl\page) {
			$this->current_page = $current_page;
		} else {
			throw new exceptions\source("Incorrect parameter 'current_page' for control 'menu'");
		}
	}

	public function setBrandLink($title, $url) {
		$this->brand = array('title' => $title, 'url' => $url);
	}

	public function enableSeparators() {
		$this->separators = true;
	}

	public function setInvertedColor() {
		$this->inverted_color = true;
	}





}

?>