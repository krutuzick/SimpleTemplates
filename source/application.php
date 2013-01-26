<?php
namespace simtpl;

class application {

	const CONFIG_XPATH_HANDLER_FACTORY = "/config/handler/factory";

	/**
	 * @var string Path to config.xml
	 */
	protected $config_path;

	/**
	 * @var \SimpleXMLElement Parsed config.xml
	 */
	protected $configXML;

	/**
	 * @var array Application instances collection
	 */
	protected static $instances = array();

	/**
	 * @var
	 */
	protected $handler_factory = null;

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
			throw new exceptions\invalidconfig("Configuration not found: {$this->config_path}");
		} elseif(!simplexml_load_file($this->config_path)) {
			throw new exceptions\invalidconfig("Failed to parse configuration: {$this->config_path}");
		}
	}

	public function getHandlerFactory() {
		$handlerName = $this->configXML->xpath(self::CONFIG_XPATH_HANDLER_FACTORY);
		if(!$handlerName || count($handlerName) != 0) {
			throw new exceptions\invalidconfig("Invalid configuration: incorrect or absent handler_factory");
		}
		if(!class_exists((string)$handlerName[0])) {
			throw new exceptions\source("Handler factory class ({$handlerName[0]}) not exists");
		}

	}

}
