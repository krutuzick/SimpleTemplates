<?php
namespace simtpl\api;
use simtpl\exceptions;

/**
 * Base API class. Provides core functionality.
 */
abstract class base {

	const PARAM_NAME = 'name';
	const PARAM_CAPTION = 'caption';
	const PARAM_TYPE = 'type';
	const PARAM_REQUIRED = 'required';

	/**
	 * @var array Array of error strings
	 */
	protected $errors = array();

	public function __construct() {
	}

	/**
	 * Execute API
	 * @return bool|mixed
	 */
	public function run() {
		$api_params = $this->getParams();
		$request_params = $this->parseParams($api_params);
		if(!$this->validateParams($request_params, $api_params)) {
			return false;
		} else {
			return $this->handle($request_params);
		}
	}

	/**
	 * @return array Array of error strings
	 */
	public function getErrors() {
		return $this->errors;
	}

	/**
	 * @return array Array of API params description
	 */
	protected abstract function getParams();

	/**
	 * @param array $params Array of params from request
	 * @return mixed Result of API execution
	 */
	protected abstract function handle($params);

	/**
	 * @param string $message Error message
	 */
	protected function addError($message) {
		$this->errors[] = $message;
	}

	/**
	 * @param array $api_params
	 * @return array Array of params from request
	 */
	protected function parseParams($api_params) {
		$this->parseRawPostData();
		$all_params = array_merge($_GET, $_POST);
		$result_params = array();
		foreach($api_params as $api_parameter) {
			foreach($all_params as $param_name => $param_value) {
				if($param_name == $api_parameter[self::PARAM_NAME]) {
					$result_params[$param_name] = $param_value;
				}
			}
		}
		return$result_params;
	}

	/**
	 * Parse RAW post data into superglobals $_POST and $_REQUEST (IE AJAX POST behavior)
	 */
	protected function parseRawPostData() {
		$vars = array();
		$raw_post_data = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : file_get_contents("php://input");
		if($raw_post_data && !empty($raw_post_data)) {
			parse_str($raw_post_data, $vars);
			foreach($vars as $key => $value) {
				$_REQUEST[$key] = $value;
				$_POST[$key] = $value;
			}
		}
	}

	/**
	 * Validate request params
	 * @param array $request_params
	 * @param array $api_params
	 * @return bool
	 * @throws \simtpl\exceptions\source
	 */
	protected function validateParams(&$request_params, $api_params) {
		foreach($api_params as $api_parameter) {
			if(!isset($api_parameter[self::PARAM_NAME]) || !isset($api_parameter[self::PARAM_CAPTION]) || !isset($api_parameter[self::PARAM_TYPE])) {
				throw new exceptions\source("Incorrect API parameters signature");
			}
			$this->checkParamRequired($api_parameter, $request_params);
			$this->checkParamType($api_parameter, $request_params);
		}
		return (count($this->getErrors()) == 0);
	}

	/**
	 * Check requested param for required restriction
	 * @param array $api_parameter
	 * @param array $request_params
	 */
	protected function checkParamRequired($api_parameter, &$request_params) {
		if(isset($api_parameter[self::PARAM_REQUIRED]) && $api_parameter[self::PARAM_REQUIRED]) {
			$param_name = $api_parameter[self::PARAM_NAME];
			if(!isset($request_params[$param_name]) || (!is_array($request_params[$param_name]) && trim($request_params[$param_name]) == "")) {
				$this->addError("Missing required parameter " . $api_parameter[self::PARAM_CAPTION]);
			}
		}
	}

	/**
	 * Check input data format for parameter
	 * @param array $api_parameter
	 * @param array $request_params
	 */
	protected function checkParamType($api_parameter, &$request_params) {
		$param_name = $api_parameter[self::PARAM_NAME];
		if(isset($request_params[$param_name]) && (is_array($request_params[$param_name]) || trim($request_params[$param_name]) != "")) {
			if(!\simtpl\validator::validate($request_params[$param_name], $api_parameter[self::PARAM_TYPE])) {
				$this->addError("Incorrect data format for parameter " . $api_parameter[self::PARAM_CAPTION]);
			}
		}
	}
}

?>