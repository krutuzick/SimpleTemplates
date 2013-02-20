<?php
namespace simtpl\controls\table;
use simtpl\controls;
use simtpl\controls\table;
use simtpl\exceptions;

/**
 * Single row of the table control
 */
class row extends controls\base {
	const COLOR_DEFAULT = '';
	const COLOR_GREEN = 'success';
	const COLOR_RED = 'error';
	const COLOR_YELLOW = 'warning';
	const COLOR_BLUE = 'info';

	protected $attributes;
	protected $color;
	protected $cells;

	/**
	 * @param array $cells Array of \simtpl\controls\table\cell
	 * @param string $color Color of the row - constant from \simtpl\controls\table\row
	 * @param array $attributes Array of extra attributes for row
	 * @throws \simtpl\exceptions\source
	 */
	public function __construct($cells = array(), $color = self::COLOR_DEFAULT, $attributes = array()) {
		$this->cells = array();
		$cells = is_array($cells) ? $cells : array($cells);
		foreach($cells as &$cell) {
			if($cell instanceof table\cell) {
				$this->cells[] = $cell;
			} else {
				throw new exceptions\source("Cell is not instance of \\simtpl\\controls\\table\\cell for table row control");
			}
		}
		$this->color = $color;
		$this->addAttributes($attributes);
	}

	/**
	 * @param string $color Color of the row - constant from \simtpl\controls\table\row
	 */
	public function setColor($color) {
		$this->color = $color;
	}

	/**
	 * @param \simtpl\controls\table\cell $cell Table cell object
	 * @throws \simtpl\exceptions\source
	 */
	public function addCell($cell) {
		if($cell instanceof table\cell) {
			$this->cells[] = $cell;
		} else {
			throw new exceptions\source("Cell is not instance of \\simtpl\\controls\\table\\cell for table row control");
		}
	}

}

?>