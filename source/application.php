<?php
namespace simtpl;

class application {

	/**
	 * @var \simtpl\configuration Configuration object
	 */
	protected $configuration;

	/**
	 * @var \simtpl\handlers\factory
	 */
	protected $handler_factory;

	/**
	 * @param string $config_path Path to config.xml
	 */
	public function __construct($config_path) {
		clearstatcache();
		\spl_autoload_register(__NAMESPACE__ . '\application::class_loader');
		$this->configuration = new configuration($config_path);
	}

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
	 */
	public function getHandlerFactory() {
		if($this->handler_factory instanceof interfaces\Ihandler_factory == false) {
			$handler_factory_name = $this->configuration->getHandlerFactoryName();
			$handler_factory_class = __NAMESPACE__ . "\\handlers\\" . $handler_factory_name;
			if(!class_exists($handler_factory_class)) {
				throw new exceptions\source("Handler factory class ({$handler_factory_class}) not exists");
			}
			$this->handler_factory = new $handler_factory_class($this->configuration);
			if($this->handler_factory instanceof interfaces\Ihandler_factory == false) {
				throw new exceptions\source("$handler_factory_class not instance of " . __NAMESPACE__ ."\\interfaces\\Ihandler_factory");
			}
		}

		return $this->handler_factory;
	}

	/**
	 * Application root directory path
	 * @return string path in filesystem
	 */
	public static function getRootPath() {
		return dirname(dirname(__FILE__));
	}
}
