<?php
namespace simtpl\exceptions;

/**
 * @todo write phpDoc
 */
class base extends \Exception {

	public function getFancyMessage() {
		$message = "Fatal error: Uncaught exception '" . \get_class($this) . "' with message: " . $this->getMessage() . PHP_EOL .
			"Trace:" . PHP_EOL;
		$traceString = array();
		$trace = array(array('file' => $this->getFile(), 'line' => $this->getLine()));
		$trace = array_merge($trace, $this->getTrace());
		foreach($trace as $step) {
			if(!isset($step['line']) || !isset($step['file'])) {
				continue;
			}
			$traceString[] = sprintf("%s (line %d)",
				$step['file'],
				$step['line']
			);
		}
		$message .= join(PHP_EOL, $traceString) . PHP_EOL . PHP_EOL;
		return $message;
	}

}
