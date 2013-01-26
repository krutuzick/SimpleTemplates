<?php
namespace simtpl\handlers;
use simtpl\interfaces;
use simtpl\exceptions;

/**
 * @todo write phpDoc
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

	protected static $instance = null;

	/**
	 * @param \simtpl\configuration $configuration Configuration object
	 */
	protected function __construct($configuration) {
		$this->configuration = $configuration;
	}

	protected function __clone() {}

	/**
	 * @param string $type Request type name - constant from \simtpl\handlers\factory
	 * @throws \simtpl\exceptions\nohandler
	 * @return \simtpl\interfaces\Ihandler
	 */
	public function getHandler($type = null) {
		$request_type = (is_null($type)) ? $this->getRequestType() : $type;
		switch($request_type) {
			case self::REQUEST_TYPE_API: return new api();
			case self::REQUEST_TYPE_HTTP: return new http();
			case self::REQUEST_TYPE_CONSOLE: return new cli();
			default: throw new exceptions\nohandler("Unknown request type: {$request_type}");
		}
	}

	/**
	 * Get current request environment type
	 * @return string Constant from simtpl\handlers\factory
	 */
	protected function getRequestType() {
		if(is_null($this->request_type)) {
			$this->request_type = self::REQUEST_TYPE_HTTP;
			if($this->isConsoleRequest()) {
				$this->request_type = self::REQUEST_TYPE_CONSOLE;
			} elseif($this->isApiRequest()) {
				$this->request_type = self::REQUEST_TYPE_API;
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
			$url_parts = explode('/', trim($script_url, '/'));
			return ($api_url_part == array_shift($url_parts));
		}
		return false;
	}

	/**
	 * @param \simtpl\configuration $configuration
	 * @return \simtpl\handlers\factory
	 */
	public static function getInstance($configuration) {
		if(self::$instance instanceof interfaces\Ihandler_factory == false) {
			self::$instance = new self($configuration);
		}
		return self::$instance;
	}
}
