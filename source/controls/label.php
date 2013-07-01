<?php
namespace simtpl\controls;

/**
 * Colored label control. Will collapse without content.
 */
class label extends base {

	const TYPE_DEFAULT = 'label';
	const TYPE_BADGE = 'badge';

	const COLOR_GRAY = '';
	const COLOR_GREEN = '-success';
	const COLOR_YELLOW = '-warning';
	const COLOR_RED = '-important';
	const COLOR_BLUE = '-info';
	const COLOR_BLACK = '-inverse';

	protected $content;
	protected $color;
	protected $type;

	/**
	 * @param string $content Content inside label
	 * @param string $color Color of label - constant from \simtpl\controls\label
	 * @param string $type Type of label - \simtpl\controls\label::TYPE_DEFAULT or \simtpl\controls\label::TYPE_BADGE
	 */
	public function __construct($content, $color = self::COLOR_GRAY, $type = self::TYPE_DEFAULT) {
		$this->addAttributes(array('class' => 'simtpl-label'));
		$this->content = $content;
		$this->color = $color;
		$this->type = $type;
	}

	/**
	 * Set type of label
	 * @param string $type Type of label - \simtpl\controls\label::TYPE_DEFAULT or \simtpl\controls\label::TYPE_BADGE
	 */
	public function setType($type) {
		$this->type = $type;
	}

	/**
	 * Set color of label
	 * @param string $color Color of label - constant from \simtpl\controls\label
	 */
	public function setColor($color) {
		$this->color = $color;
	}

	/**
	 * Get real bootstrap css class for selected color and type
	 * @return string
	 */
	protected function getFullColorClass() {
		return (!empty($this->color)) ? $this->type . $this->color : '';
	}
}
?>