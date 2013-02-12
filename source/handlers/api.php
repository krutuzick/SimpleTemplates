<?php
namespace simtpl\handlers;
use simtpl\exceptions;

/**
 * @todo write phpDoc
 */
class api extends base {

	/**
	 * @var string Name of requested API
	 */
	protected $api_name;

	public function handle() {
		$result = array(
			'result' => false,
			'errors' => array(),
		);
		try {
			$this->api_name = $this->parseApiName();
			$apiClass = "\\simtpl\\api\\{$this->api_name}";
			if(!class_exists($apiClass)) {
				throw new exceptions\source('Failed to load requested API');
			}
			$api = new $apiClass();
			if($api instanceof \simtpl\api\base) {
				$result['result'] = $api->run();
				$result['errors'] = $api->getErrors();
			} else {
				throw new exceptions\source('Incorrect API class');
			}
		} catch(exceptions\base $e) {
			$result['errors'][] = $e->getMessage();
		}
		return json_encode($result);
	}

	/**
	 * @return string API name from request uri
	 */
	protected function parseApiName() {
		$url = array_shift(explode('?', $_SERVER['REQUEST_URI']));
		$url = trim($url, "/");
		$api_name = substr($url, strlen($this->configuration->getApiUrlPart()));
		$api_name = trim($api_name, "/");
		$api_name = str_replace("/", "\\", $api_name);
		return $api_name;
	}
}
