<?php
namespace simtpl\libs;
use simtpl\exceptions;

/**
 * Class to perform resources compilation/compression
 */
class filesCompiler {
	const TYPE_CSS = 'css';
	const TYPE_JS = 'js';

	protected $type;
	protected $source_files = array();
	protected $result_file;

	/**
	 * @param string $type Files type name
	 * @param array $source_files Array of source files paths
	 * @param string $result_file Result compiled file full path
	 */
	public function __construct($type, $source_files, $result_file) {
		$this->type = $type;
		$this->result_file = $result_file;
		$this->source_files = is_array($source_files) ? $source_files : array($source_files);
	}

	/**
	 * Perform compilation of resource files
	 * @throws \simtpl\exceptions\filecompile
	 * @throws \simtpl\exceptions\source
	 * @return bool
	 */
	public function compile() {
		if(file_exists($this->result_file)) {
			unlink($this->result_file);
			clearstatcache();
			if(file_exists($this->result_file)) {
				throw new exceptions\filecompile("Failed to delete older compiled file during compilation");
			}
		}
		switch($this->type) {
			case self::TYPE_CSS:
				$this->compileCss();
				break;
			case self::TYPE_JS:
				$this->compileJs();
				break;
			default:
				throw new exceptions\source("Failed to compile resources: unknown resource type");
		}
		clearstatcache();
		return file_exists($this->result_file);
	}

	/**
	 * Compile and save js files
	 */
	protected function compileJs() {
		if(count($this->source_files) == 0) {
			file_put_contents($this->result_file, "", FILE_APPEND);
		} else {
			foreach($this->source_files as $src_file) {
				file_put_contents($this->result_file, file_get_contents($src_file) . PHP_EOL, FILE_APPEND);
			}
		}
	}

	/**
	 * Compile and save css files
	 */
	protected function compileCss() {
		if(count($this->source_files) == 0) {
			file_put_contents($this->result_file, "", FILE_APPEND);
		} else {
			foreach($this->source_files as $src_file) {
				file_put_contents($this->result_file, file_get_contents($src_file) . PHP_EOL, FILE_APPEND);
			}
		}
	}

}

?>