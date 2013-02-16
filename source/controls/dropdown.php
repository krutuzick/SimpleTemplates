<?php
namespace simtpl\controls;
use simtpl\exceptions;

/**
 * @todo phpDoc
 */
class dropdown extends base {

	protected $items = array();
	protected $hide_if_empty = false;

	public function __construct($hide_if_empty = false) {
		$this->addAttributes(array('class' => 'simtpl-dropdown'));
		$this->addAttributes(array(
			'class' => 'dropdown-menu',
			'role' => 'menu'
		));
		$this->hide_if_empty = $hide_if_empty;
	}

	/**
	 * Add item to dropdown
	 * @param \simtpl\controls\dropdown\item $item
	 * @throws \simtpl\exceptions\source
	 */
	public function addItem($item) {
		if($item instanceof \simtpl\controls\dropdown\item) {
			$this->items[] = $item;
		} else {
			throw new exceptions\source("Incorrect parameter for adding item to control 'dropdown'");
		}
	}
}

?>