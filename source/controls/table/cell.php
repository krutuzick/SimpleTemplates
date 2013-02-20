<?php
namespace simtpl\controls\table;
use simtpl\controls;

/**
 * Single cell for table row control
 */
class cell extends controls\base {
	const TYPE_DEFAULT = 'td';
	const TYPE_HEADER = 'th';

	protected $value;
	protected $type;

	/**
	 * @param string $value Value in the table cell
	 * @param string $type Type of cell - constant from \simtpl\controls\table\cell
	 * @param array $attributes Array of extra attributes for cell
	 */
	public function __construct($value, $type = self::TYPE_DEFAULT, $attributes = array()) {
		$this->value = $value;
		$this->type = $type;
		$this->addAttributes($attributes);
	}

	/**
	 * @param string $type Type of cell - constant from \simtpl\controls\table\cell
	 */
	public function setType($type) {
		$this->type = $type;
	}

	/**
	 * @param string $value Value in the table cell
	 */
	public function setValue($value) {
		$this->value = $value;
	}

}

?>