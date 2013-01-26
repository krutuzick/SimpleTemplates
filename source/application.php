<?php
namespace simtpl;

class application {

	/**
	 * @var \simtpl\configuration Configuration object
	 */
	protected $configuration;

	/**
	 * @var array Application instances collection
	 */
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
		clearstatcache();
		\spl_autoload_register(__NAMESPACE__ . '\application::class_loader');
		$this->configuration = new configuration($config_path);
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
	 * @return \simtpl\interfaces\Ihandler_factory Handlers factory
	 * @throws exceptions\source
	 * @throws exceptions\invalidconfig
	 */
	public function getHandlerFactory() {
		$handler_name = $this->configuration->getHandlerFactoryName();
		if(!class_exists((string)$handler_name[0])) {
			throw new exceptions\source("Handler factory class ({$handler_name[0]}) not exists");
		}
		$handler_class_name = __NAMESPACE__ . "\\handlers\\" . (string)$handler_name[0];
		if(!is_subclass_of($handler_class_name, "\\interfaces\\Ihandler_factory")) {
			throw new exceptions\source("Handler factory class ($handler_name[0]) is not implements interface ". __NAMESPACE__ ."\\interfaces\\Ihandler_factory");
		}
		$handler_factory = \call_user_func(__NAMESPACE__ . "\\handlers\\" . (string)$handler_name[0] . "::getInstance", $this->configuration);
		if($handler_factory instanceof interfaces\Ihandler_factory == false) {
			throw new exceptions\source("$handler_class_name::getInstance() does not returns instance of " . __NAMESPACE__ ."\\interfaces\\Ihandler_factory");
		}
		return $handler_factory;
	}

}
