<?php
namespace simtpl\controls\dropdown;
use simtpl\exceptions;
/**
 * @todo phpDoc
 */
class item extends \simtpl\controls\base {
	protected $caption;
	protected $link;
	protected $submenu;
	protected $disabled = false;
	protected $is_divider = false;

	/**
	 * @param string $caption
	 * @param string $link
	 * @param \simtpl\controls\dropdown|null $submenu
	 * @param bool $disabled
	 * @throws \simtpl\exceptions\source
	 */
	public function __construct($caption, $link = "javascript:void(0)", &$submenu = null, $disabled = false) {
		$this->caption = trim($caption);
		$this->link = trim($link);
		$this->disabled = $disabled;
		if($submenu instanceof \simtpl\controls\dropdown) {
			$this->submenu = $submenu;
			$this->addAttributes(array('class' => 'dropdown-submenu'));
		} elseif(!is_null($submenu)) {
			throw new exceptions\source("Incorrect parameter for control 'dropdown' item");
		}
	}

	public function setIsDivider() {
		$this->is_divider = true;
	}

	public function setCaption($caption) {
		$this->caption = trim($caption);
	}

	public function setDisabled() {
		$this->disabled = true;
		$this->addAttributes(array('class' => 'disabled'));
	}

	public function setLink($link) {
		$this->link = $link;
	}

	public function setSubmenu($submenu) {
		if($submenu instanceof \simtpl\controls\dropdown || is_null($submenu)) {
			$this->submenu = $submenu;
			$this->addAttributes(array('class' => 'dropdown-submenu'));
		} else {
			throw new exceptions\source("Incorrect parameter for control 'dropdown' item");
		}
	}


}

?>