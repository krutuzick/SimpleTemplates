<?php
namespace simtpl\handlers;

/**
 * @todo phpDoc
 */
abstract class base {
	/**
	 * @var \simtpl\configuration
	 */
	protected $configuration;

	/**
	 * @param \simtpl\configuration $configuration
	 */
	public function __construct($configuration) {
		$this->configuration = $configuration;
	}

	/**
	 * Handle request and return result to show
	 * @return string
	 */
	abstract public function handle();
}

?>