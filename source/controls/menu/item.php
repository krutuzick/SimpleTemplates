<?php
namespace simtpl\controls\menu;
use simtpl\exceptions;

/**
 * @todo phpDoc
 */
class item extends \simtpl\controls\base {

	/**
	 * @var \simtpl\page
	 */
	protected $page;
	/**
	 * @var \simtpl\controls\dropdown
	 */
	protected $submenu;

	/**
	 * @param \simtpl\page $page Page object for menu item
	 * @throws \simtpl\exceptions\source
	 */
	public function __construct(&$page) {
		if($page instanceof \simtpl\page == false) {
			throw new exceptions\source("Incorrect parameter 'page' for control 'menu' item");
		}
		$this->page = $page;
		$this->submenu = $this->getSubmenu($this->page->getChildren());
		$this->addAttributes(array('class' => 'dropdown'));
		$this->addAttributes(array('class' => 'simtpl-menu-link-' . $this->page->getName()));
	}

	protected function getSubmenu(&$children) {
		if(count($children) == 0) return null;
		$submenu = new \simtpl\controls\dropdown(true);
		foreach($children as &$childPage) {
			if($childPage->getHiddenFromMenu()) continue;
			$child_item = new \simtpl\controls\dropdown\item($childPage->getCaption(), $childPage->getUrl(), $this->getSubmenu($childPage->getChildren()));
			$submenu->addItem($child_item);
		}
		return $submenu;
	}

}

?>