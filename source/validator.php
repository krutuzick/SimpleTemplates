<?php
namespace simtpl;
use simtpl\exceptions;

/**
 * Data validation class
 */
class validator {
	const TYPE_NUMBER = 'Number';
	const TYPE_BOOLEAN = 'Boolean';
	const TYPE_STRING = 'String';
	const TYPE_ARRAY = 'Array';

	/**
	 * Validate value by type
	 * @param mixed $value Value to validate
	 * @param string $type Data type for validation
	 * @return boolean
	 * @throws exceptions\source
	 */
	public static function validate(&$value, $type) {
		$method_name = "valid{$type}";
		if(!method_exists(__CLASS__, $method_name)) {
			throw new exceptions\source("Unknown data type: {$type}");
		}
		return self::$method_name($value);
	}

	/**
	 * @param mixed $value
	 * @return bool
	 */
	protected static function validNumber(&$value) {
		return is_numeric($value);
	}

	/**
	 * @param mixed $value
	 * @return bool Value will be converted to boolean if result is TRUE
	 */
	protected static function validBoolean(&$value) {
		if($value !== false && $value !== true && !in_array($value, array('0', '1', '', 'true', 'false'))) {
			return false;
		} else {
			$value = ($value === true || $value == '1' || $value == 'true') ? true : false;
			return true;
		}
	}

	/**
	 * @param mixed $value
	 * @return bool
	 */
	protected static function validString(&$value) {
		return true;
	}

	/**
	 * @param mixed $value
	 * @return bool
	 */
	protected static function validArray(&$value) {
		return is_array($value);
	}
}

?>