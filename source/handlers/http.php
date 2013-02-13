<?php
namespace simtpl\handlers;
use simtpl\exceptions;
use simtpl\libs;

/**
 * Handler for default HTTP request. Renders page based by URL
 */
class http extends base {

	const RESOURCE_CSS = 'css';
	const RESOURCE_JS = 'js';

	protected $path_parts = null;
	protected $page = null;

	public function handle() {
		$page = $this->getCurrentPage();
		if($page->getRedirect() !== false) {
			return $this->doRedirect($page->getRedirect());
		} else {
			return $this->renderPage($page);
		}
	}

	/**
	 * @return array Array of current path parts
	 */
	protected function getPathParts() {
		if(is_null($this->path_parts)) {
			$url = array_shift(explode('?', $_SERVER['REQUEST_URI']));
			$url = trim($url, "/");
			$this->path_parts = ($url == "") ? array() : explode("/", $url);
		}
		return $this->path_parts;
	}

	/**
	 * @return \simtpl\page Current page object
	 * @throws \simtpl\exceptions\nopage
	 */
	protected function getCurrentPage() {
		if($this->page instanceof \simtpl\page == false) {
			$path_parts = $this->getPathParts();
			if(empty($path_parts)) {
				$this->page = $this->getDefaultPage($this->configuration->getStructure());
			} else {
				$this->page = $this->getPageByPath($this->configuration->getStructure(), $path_parts);
			}
			if($this->page instanceof \simtpl\page == false) {
				throw new exceptions\nopage("Failed to get current page object");
			}
		}
		return $this->page;
	}

	/**
	 * @param array $pages Array of \simtpl\page objects
	 * @return \simtpl\page|null Default page object
	 */
	protected function getDefaultPage(&$pages) {
		$index_page = null;
		foreach($pages as &$page) {
			if($page->getIndex()) {
				$index_page = $page;
				break;
			}
			$index_page = $this->getDefaultPage($page->getChildren());
			if($index_page instanceof \simtpl\page) {
				break;
			}
		}
		return $index_page;
	}

	/**
	 * @param array $pages Structure - array of \simtpl\page objects
	 * @param array $path_parts Array of path parts
	 * @return \simtpl\page|null Page object or null if not found
	 */
	protected function getPageByPath(&$pages, $path_parts) {
		if(empty($path_parts)) {
			return null;
		}
		$searching_page = null;
		$top_level_page = array_shift($path_parts);
		foreach($pages as &$page) {
			if($page->getName() == $top_level_page) {
				$searching_page = (count($path_parts) == 0) ? $page : $this->getPageByPath($page->getChildren(), $path_parts);
				break;
			}
		}
		return $searching_page;
	}

	/**
	 * Send headers for 301 redirect
	 * @param string $redirect_location URL to redirect
	 * @return string Empty string
	 */
	protected function doRedirect($redirect_location) {
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: {$redirect_location}");
		return "";
	}

	/**
	 * @return string Full path to templates folder
	 */
	protected function getTemplatesPath() {
		return dirname(__FILE__) . '/../../templates/';
	}

	/**
	 * @param \simtpl\page $page Page object
	 * @return string Full path to page template file
	 * @throws \simtpl\exceptions\nopage
	 */
	protected function getPageTemplatePath($page) {
		$templates_root = $this->getTemplatesPath();
		$pages_templates_root = trim($this->configuration->getTemplatesFolder(), " \\/") . "/";
		$template_file = $templates_root . $pages_templates_root . trim($page->getTemplate(), " \\/");
		clearstatcache();
		if(!file_exists($template_file)) {
			throw new exceptions\nopage("No template file for page \"" . $page->getUrl() . "\"");
		}
		return $template_file;
	}

	/**
	 * @param \simtpl\page $page Page object to render
	 * @return string Rendered page
	 * @throws \simtpl\exceptions\nopage
	 */
	protected function renderPage($page) {
		$templates_index = $this->getTemplatesPath() . trim($this->configuration->getIndexTemplate(), " \\/");
		clearstatcache();
		if(!file_exists($templates_index)) {
			throw new exceptions\nopage("No index template file found");
		}
		ob_start();
		include($templates_index);
		return ob_get_clean();
	}

	/**
	 * Get controls resource html tags with precompile (if autocompile option set in config or compiled file is outdated)
	 * @param string $type Type of resource - constant from simtpl/handlers/http
	 * @return string HTML resource tags
	 * @throws \simtpl\exceptions\filecompile
	 */
	protected function getControlsResource($type) {
		$controls_files = $this->getResourceFilesRecurrent($type);
		$result = "";
		if($this->configuration->getIsResourcesAutocompress()) {
			$latest_file = 0;
			if(count($controls_files) > 0) {
				$latest_file = max(array_map(function ($file_path) {
					return file_exists($file_path) ? filemtime($file_path) : 0;
				}, $controls_files));
			}
			if(!file_exists($this->getCompressedControlsResource($type)) || filemtime($this->getCompressedControlsResource($type)) < $latest_file) {
				$filesCompiller = new libs\filesCompiler($type, $controls_files, $this->getCompressedControlsResource($type));
				if(!$filesCompiller->compile()) {
					throw new exceptions\filecompile("Failed to compile controls {$type} resource file");
				}
			}
			$result .= $this->getResourceTag($type, $this->getCompressedControlsResource($type, true));
		} else {
			foreach($controls_files as $controls_file) {
				$href = substr($controls_file, strlen(\simtpl\application::getRootPath() . "/resources") - 1);
				$result .= $this->getResourceTag($type, $href);
			}
		}
		return $result;
	}

	/**
	 * Get all resource file paths
	 * @param string $type Type of files (css, js)
	 * @param string $folder Folder to search. If empty - default folder will be searched
	 * @return array Array of full file paths
	 */
	protected function getResourceFilesRecurrent($type, $folder = '') {
		$files = array();
		if($folder == '') {
			$folder = \simtpl\application::getRootPath() . "/resources/{$type}/controls";
		}
		$files_in_folder = glob($folder . "/*");
		foreach($files_in_folder as $file_path) {
			if(is_dir($file_path)) {
				$files = array_merge($files, $this->getResourceFilesRecurrent($type, rtrim($file_path, "\\/ ")));
			} elseif(preg_match("/^.+\.{$type}$/i", $file_path)) {
				$files[] = $file_path;
			}
		}
		return $files;
	}

	/**
	 * Get compiled resource file name
	 * @param string $type Type of resource - constant from simtpl/handlers/http
	 * @param bool $as_url Flag, if true - get http url path to resource file. Otherwise - full path in filesystem
	 * @return string Compiled resource file url or path
	 */
	protected function getCompressedControlsResource($type, $as_url = false) {
		return $as_url ? "/{$type}/controls.{$type}" : \simtpl\application::getRootPath() . "/resources/{$type}/controls.{$type}";
	}

	/**
	 * Generate HTML tag for resource
	 * @param string $type Type of resource - constant from simtpl/handlers/http
	 * @param string $url Url of resource
	 * @return string HTML tag for resource
	 * @throws \simtpl\exceptions\source
	 */
	protected function getResourceTag($type, $url) {
		switch($type) {
			case self::RESOURCE_CSS:
				return "<link rel=\"stylesheet\" href=\"{$url}\"/>";
			case self::RESOURCE_JS:
				return "<script type=\"text/javascript\" src=\"{$url}\"></script>";
			default:
				throw new \simtpl\exceptions\source("Failed to get resource tag: unknown type {$type}");
		}
	}

}
