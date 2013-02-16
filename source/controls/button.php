<?php
namespace simtpl\controls;
use simtpl\exceptions;

/**
 * Button / link control
 */
class button extends base {
	const TYPE_GRAY = '';
	const TYPE_BLUE = 'btn-primary';
	const TYPE_AQUAMARINE = 'btn-info';
	const TYPE_GREEN = 'btn-success';
	const TYPE_ORANGE = 'btn-warning';
	const TYPE_RED = 'btn-danger';
	const TYPE_BLACK = 'btn-inverse';
	const TYPE_LINK = 'btn-link';

	const SIZE_LARGE = 'btn-large';
	const SIZE_DEFAULT = '';
	const SIZE_SMALL = 'btn-small';
	const SIZE_MINI = 'btn-mini';

	const TAG_TYPE_A = 'a';
	const TAG_TYPE_BUTTON = 'button';
	const TAG_TYPE_INPUT_BUTTON = 'input_button';
	const TAG_TYPE_INPUT_SUBMIT = 'input_submit';

	protected $type;
	protected $tag_type;
	protected $size;
	protected $is_disabled;
	protected $caption;
	protected $link;
	protected $title;

	/**
	 * @var \simtpl\controls\dropdown
	 */
	protected $dropdown;
	protected $separate_dropdown;

	/**
	 * @var \simtpl\controls\icon
	 */
	protected $icon;

	/**
	 * @param string $caption Text on button
	 * @param string|null $link URL of the button (if tag type is \simtpl\controls\button::TAG_TYPE_A)
	 * @param string|null $title Title attribute
	 * @param string $type Color/type of the button - constant \simtpl\controls\button::TYPE_*
	 * @param string $size Size of the button - constant \simtpl\controls\button::SIZE_*
	 * @param \simtpl\controls\icon|null $icon Icon control to use in button
	 * @param string $tag_type Type of tag to render - constant \simtpl\controls\button::TAG_TYPE_*
	 * @throws \simtpl\exceptions\source
	 */
	public function __construct($caption, $link = null, $title = null, $type = self::TYPE_GRAY, $size = self::SIZE_DEFAULT, $icon = null, $tag_type = self::TAG_TYPE_A) {
		$this->caption = $caption;
		$this->link = is_null($link) ? "javascript:void(0)" : $link;
		$this->title = $title;
		$this->type = $type;
		$this->size = $size;
		if(is_null($icon) || $icon instanceof icon) {
			$this->icon = $icon;
		} else {
			throw new exceptions\source("Invalid parameter 'icon' for button control");
		}
		$this->tag_type = $tag_type;
		$this->is_disabled = false;
		$this->addAttributes(array('class' => 'simtpl-button'));
		$this->addAttributes(array('class' => 'btn'));
	}

	/**
	 * @param string $caption Text on button
	 */
	public function setCaption($caption) {
		$this->caption = $caption;
	}

	/**
	 * @param \simtpl\controls\dropdown|null $dropdown Dropdown control to use in button
	 * @param bool $separate Flag - separate dropdown from button (true) or make it whole (false, by default). For TAG_TYPE_INPUT_* it is always separate.
	 * @throws \simtpl\exceptions\source
	 */
	public function setDropdown($dropdown, $separate = false) {
		if(is_null($dropdown) || $dropdown instanceof dropdown) {
			$this->dropdown = $dropdown;
			if($this->tag_type == self::TAG_TYPE_INPUT_BUTTON || $this->tag_type == self::TAG_TYPE_INPUT_SUBMIT) {
				$this->separate_dropdown = true;
			} else {
				$this->separate_dropdown = $separate;
			}
		} else {
			throw new exceptions\source("Invalid parameter 'submenu' for button control");
		}
	}

	/**
	 * @param \simtpl\controls\icon|null $icon Icon control to use in button
	 * @throws \simtpl\exceptions\source
	 */
	public function setIcon($icon) {
		if(is_null($icon) || $icon instanceof icon) {
			$this->icon = $icon;
		} else {
			throw new exceptions\source("Invalid parameter 'icon' for button control");
		}
	}

	/**
	 * Disable button
	 */
	public function setIsDisabled() {
		$this->is_disabled = true;
	}

	/**
	 * @param string $link URL of the button (if tag type is \simtpl\controls\button::TAG_TYPE_A)
	 */
	public function setLink($link) {
		$this->link = is_null($link) ? "javascript:void(0)" : $link;
	}

	/**
	 * @param string $size Size of the button - constant \simtpl\controls\button::SIZE_*
	 */
	public function setSize($size) {
		$this->size = $size;
	}

	/**
	 * @param string $tag_type Type of tag to render - constant \simtpl\controls\button::TAG_TYPE_*
	 */
	public function setTagType($tag_type) {
		$this->tag_type = $tag_type;
	}

	/**
	 * @param string $title Title attribute
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * @param string $type Color/type of the button - constant \simtpl\controls\button::TYPE_*
	 */
	public function setType($type) {
		$this->type = $type;
	}

}

?>