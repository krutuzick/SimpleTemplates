<?php
namespace simtpl;

/**
 * @todo phpDoc
 */
class configuration {

	const CONFIG_XPATH_HANDLER_FACTORY = "/config/handler/factory";
	const CONFIG_XPATH_API_URL_PART = "/config/api/url";

	/**
	 * @var string Path to config.xml
	 */
	protected $config_path;

	/**
	 * @var \SimpleXMLElement Parsed config.xml
	 */
	protected $configXML;

	/**
	 * @param string $config_path Path to config.xml
	 * @throws exceptions\invalidconfig
	 */
	public function __construct($config_path) {
		$this->config_path = $config_path;

		if(!file_exists($this->config_path)) {
			throw new exceptions\invalidconfig("Configuration not found: {$this->config_path}");
		}

		$this->configXML = \simplexml_load_file($this->config_path);
		if($this->configXML instanceof \SimpleXMLElement == false) {
			throw new exceptions\invalidconfig("Failed to parse configuration: {$this->config_path}");
		}
	}

	/**
	 * @return string Name of the handler factory class
	 * @throws exceptions\invalidconfig
	 */
	public function getHandlerFactoryName() {
		$handler_name = $this->configXML->xpath(self::CONFIG_XPATH_HANDLER_FACTORY);
		if(!$handler_name || count($handler_name) != 0) {
			throw new exceptions\invalidconfig("Invalid configuration: incorrect or absent handler factory class name");
		}
		return $handler_name;
	}

	public function getApiUrlPart() {
		$api_url = $this->configXML->xpath(self::CONFIG_XPATH_API_URL_PART);
		if(!$api_url || count($api_url) != 0) {
			throw new exceptions\invalidconfig("Invalid configuration: incorrect or absent api url part");
		}
		return $api_url;
	}


}

?>