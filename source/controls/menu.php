<?php
namespace simtpl\controls;
use simtpl\exceptions;

/**
 * @todo phpDoc
 */
class menu extends base {

	protected $items = array();
	protected $current_page;
	protected $brand;
	protected $separators = false;
	protected $inverted_color = false;
	protected $fixed_top_style = true;

	public function __construct(&$structure, &$current_page) {
		if($current_page instanceof \simtpl\page) {
			$this->current_page = $current_page;
		} else {
			throw new exceptions\source("Incorrect parameter 'current_page' for control 'menu'");
		}
		$this->initMenuItems($structure);
		$this->addAttributes(array('class' => 'simtpl-menu'));
		$this->addAttributes(array('class' => 'navbar'));
	}

	protected function initMenuItems(&$structure) {
		$pages_structure = is_array($structure) ? $structure : array($structure);
		foreach($pages_structure as &$page) {
			if($page->getHiddenFromMenu()) continue;
			$menu_item = new \simtpl\controls\menu\item($page);
			if($page === $this->current_page || in_array($page, $this->current_page->getParents(), true)) {
				$menu_item->addAttributes(array('class' => 'active'));
			}
			$this->items[] = $menu_item;
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

	public function disableFixedTopStyle() {
		$this->fixed_top_style = false;
	}

}

?>