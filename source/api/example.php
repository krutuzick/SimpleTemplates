<?php
namespace simtpl\api;
/**
 * Demo API
 */
class example extends base {

	/**
	 * @return array Array of API params description
	 */
	protected function getParams() {
		return array(
			array(
				self::PARAM_NAME => 'person',
				self::PARAM_CAPTION => 'Demo user to show',
				self::PARAM_TYPE => \simtpl\validator::TYPE_STRING,
				self::PARAM_REQUIRED => true,
			),
			array(
				self::PARAM_NAME => 'data',
				self::PARAM_CAPTION => 'Demo optional data',
				self::PARAM_TYPE => \simtpl\validator::TYPE_ARRAY,
			),
		);
	}

	/**
	 * @param array $params Array of params from request
	 * @return mixed Result of API execution
	 */
	protected function handle($params) {
		return $params;
	}
}

?>