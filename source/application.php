<?php
namespace simtpl;

class application {

	protected $config_path;

	protected static $instances = array();

	/**
	 * @param string $config_path
	 * @return application
	 */
	public static function getInstance($config_path) {
		if(!isset(self::$instances[$config_path])) {
			self::$instances[$config_path] = new self($config_path);
		}
		return self::$instances[$config_path];
	}

	/**
	 * Overloaded protected constructor - singleton design pattern
	 */
	protected function __construct($config_path) {
		$this->config_path = $config_path;
	}

	/**
	 * Overloaded clone method - singleton design pattern
	 */
	protected function __clone() {}

	/**
	 * Class autoloader
	 * @param string $class_name class name to load (with namespace)
	 * @return bool
	 */
	public static function class_loader($class_name) {
		if(strpos($class_name, __NAMESPACE__) === 0) {
			$class_name = substr($class_name, strlen(__NAMESPACE__));
		}
		$class_path = dirname(__FILE__)  . "/" . trim(str_replace("\\", "/", $class_name), "/") . ".php";
		if(file_exists($class_path)) {
			require $class_path;
			return true;
		}
		return false;
	}

	/**
	 * Load configuration and init application instance
	 */
	public function init() {
		clearstatcache();
		\spl_autoload_register(__NAMESPACE__ . '\application::class_loader');
		if(!file_exists($this->config_path)) {
			throw new exception\noconfig("Configuration not found: {$this->config_path}");
		}
	}
}
