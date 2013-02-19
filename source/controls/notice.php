<?php
namespace simtpl\controls;

/**
 * Colored (closable optionally) block with text. Useful for different type of notices and messages.
 */
class notice extends base {
	const COLOR_YELLOW = '';
	const COLOR_RED = 'alert-error';
	const COLOR_GREEN = 'alert-success';
	const COLOR_BLUE = 'alert-info';

	protected $content;
	protected $closable;

	/**
	 * @param string $content HTML content of the notice
	 * @param string $color Color of the notice - constant from simtpl\controls\notice
	 * @param bool $closable Flag - true - notice will have a cross button that will close it (by default). False - no cross button.
	 */
	public function __construct($content, $color = self::COLOR_YELLOW, $closable = true) {
		$this->addAttributes(array('class' => 'simtpl-notice'));
		$this->addAttributes(array('class' => 'alert'));
		$this->addAttributes(array('class' => 'alert-block'));
		$this->addAttributes(array('class' => $color));
		$this->content = $content;
		$this->color = $color;
		$this->closable = $closable;
	}

}

?>