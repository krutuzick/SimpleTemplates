<?php
namespace simtpl\handlers;

/**
 * @todo write phpDoc
 */
class http extends base {

	protected $path_parts;
	protected $current_section;

	public function handle() {
		$this->path_parts = $this->parseRequestPath();
		return "55555";
	}

	protected function parseRequestPath() {
		$url = array_shift(explode('?', $_SERVER['REQUEST_URI']));
		$url = trim($url, "/");
		if($url == "") $url = "index";
		$url_parts = explode("/", $url);
		$this->current_section = array_pop($url_parts);
		$this->path_parts = $url_parts;
	}
}
