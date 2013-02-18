<?php
namespace simtpl\controls;
use simtpl\exceptions;

/**
 * @todo phpDoc
 */
class dropdown extends base {

	protected $items = array();
	protected $hide_if_empty = false;
	protected $visible_initial = false;

	/**
	 * @param array $items Array of \simtpl\controls\dropdown\item
	 * @param bool $hide_if_empty Flag - do not render control if it has no items
	 * @param bool $visible_initial Flag - set visible on creation, not only by trigger
	 */
	public function __construct($items = array(), $hide_if_empty = false, $visible_initial = false) {
		$this->addAttributes(array('class' => 'simtpl-dropdown'));
		$this->addAttributes(array(
			'class' => 'dropdown-menu',
			'role' => 'menu'
		));
		$this->hide_if_empty = $hide_if_empty;
		$this->visible_initial = $visible_initial;
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

	/**
	 * Set dropdown visible on creation, not by trigger only
	 */
	public function setVisible() {
		$this->visible_initial = true;
	}
}

?>