<?php
namespace simtpl\handlers;
use simtpl\interfaces;
use simtpl\exceptions;

/**
 * Factory for detecting type of request and getting correct handler object 
 */
class factory implements interfaces\Ihandler_factory {

	const REQUEST_TYPE_API = 'api';
	const REQUEST_TYPE_HTTP = 'http';
	const REQUEST_TYPE_CONSOLE = 'cli';

	/**
	 * @var string Current environment request type (use getter)
	 */
	protected $request_type = null;

	/**
	 * @var \simtpl\configuration Configuration object
	 */
	protected $configuration = null;

	/**
	 * @param \simtpl\configuration $configuration Configuration object
	 */
	public function __construct($configuration) {
		$this->configuration = $configuration;
	}

	/**
	 * @param string $type Request type name - constant from \simtpl\handlers\factory
	 * @throws \simtpl\exceptions\nohandler
	 * @return \simtpl\handlers\base
	 */
	public function getHandler($type = null) {
		$request_type = (is_null($type)) ? $this->getRequestType() : $type;
		if(!$request_type) {
			throw new exceptions\nohandler("Unknown request type: {$request_type}");
		}
		$handler_name = $this->configuration->getHandlerName($request_type);
		$handler_class = __NAMESPACE__ . "\\" . $handler_name;
		$handler = new $handler_class($this->configuration);
		if($handler instanceof base == false) {
			throw new exceptions\nohandler("Handler {$handler_class} is not instance of " . __NAMESPACE__ . "\\base");
		}
		return $handler;
	}

	/**
	 * Get current request environment type
	 * @return string Constant from simtpl\handlers\factory
	 */
	protected function getRequestType() {
		if(is_null($this->request_type)) {
			if($this->isConsoleRequest()) {
				$this->request_type = self::REQUEST_TYPE_CONSOLE;
			} elseif($this->isApiRequest()) {
				$this->request_type = self::REQUEST_TYPE_API;
			} else {
				$this->request_type = self::REQUEST_TYPE_HTTP;
			}
		}
		return $this->request_type;
	}

	/**
	 * @return bool
	 */
	protected function isConsoleRequest() {
		if(!is_null($this->request_type)) {
			return $this->request_type == self::REQUEST_TYPE_CONSOLE;
		}
		return (!isset($_SERVER['DOCUMENT_ROOT']) || strlen($_SERVER['DOCUMENT_ROOT']) == 0);
	}

	/**
	 * @return bool
	 */
	protected function isApiRequest() {
		if(!is_null($this->request_type)) {
			return $this->request_type == self::REQUEST_TYPE_API;
		}
		if(isset($_SERVER['REQUEST_URI'])) {
			$api_url_part = $this->configuration->getApiUrlPart();
			$script_url = array_shift(explode('?', $_SERVER['REQUEST_URI']));
			$script_url = trim($script_url, "/") . "/";
			return (strpos($script_url, $api_url_part) === 0);
		}
		return false;
	}

}
