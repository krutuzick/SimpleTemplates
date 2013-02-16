<?php
namespace simtpl\controls;
use simtpl\exceptions;

/**
 * @todo phpDoc
 */
class dropdown extends base {

	protected $items = array();
	protected $hide_if_empty = false;

	/**
	 * @param array $items Array of \simtpl\controls\dropdown\item
	 * @param bool $hide_if_empty Flag - do not render control if it has no items
	 */
	public function __construct($items = array(), $hide_if_empty = false) {
		$this->addAttributes(array('class' => 'simtpl-dropdown'));
		$this->addAttributes(array(
			'class' => 'dropdown-menu',
			'role' => 'menu'
		));
		$this->hide_if_empty = $hide_if_empty;
		$this->addItems($items);
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

	/**
	 * Add multiple items to dropdown
	 * @param array $items Array of \simtpl\controls\dropdown\item
	 * @throws \simtpl\exceptions\source
	 */
	public function addItems($items) {
		$items = is_array($items) ? $items : array($items);
		foreach($items as $item) {
			$this->addItem($item);
		}
	}
}

?>