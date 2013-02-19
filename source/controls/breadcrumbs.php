<?php
namespace simtpl\controls;
use simtpl\exceptions;

/**
 * Breadcrumbs control for \simtpl\page
 */
class breadcrumbs extends base {
	/**
	 * @var \simtpl\page
	 */
	protected $page;
	protected $separator;
	protected $collapse_if_empty;
	protected $home_page_text;
	/**
	 * @var \simtpl\controls\icon
	 */
	protected $home_page_icon;

	/**
	 * @param \simtpl\page $page Page object for breadcrumbs
	 * @param string|null $home_page_text Caption (html) for home path part. If null - no home path part will render
	 * @param \simtpl\controls\icon|null $home_page_icon Icon for home path part
	 * @param bool $collapse_if_empty Flag - do not render control if it is empty
	 * @param string $separator Separator of path parts
	 * @throws \simtpl\exceptions\source
	 */
	public function __construct(&$page, $home_page_text = null, $home_page_icon = null, $collapse_if_empty = true, $separator = "/") {
		if($page instanceof \simtpl\page) {
			$this->page = $page;
		} else {
			throw new exceptions\source("Page is not instance of \\simtpl\\page in breadcrumbs control");
		}
		$this->home_page_text = $home_page_text;
		if($home_page_icon instanceof icon || is_null($home_page_icon)) {
			$this->home_page_icon = $home_page_icon;
		} else {
			throw new exceptions\source("Home page icon is not instance of \\simtpl\\controls\\icon in breadcrumbs control");
		}
		$this->collapse_if_empty = $collapse_if_empty;
		$this->separator = $separator;
		$this->addAttributes(array('class' => 'simtpl-breadcrumbs'));
		$this->addAttributes(array('class' => 'breadcrumb'));
	}

	/**
	 * @return bool Need to render control (true) or not (false)
	 */
	protected function needToRender() {
		return !($this->collapse_if_empty && count($this->page->getParents()) == 0 && !$this->needToRenderHome());
	}

	/**
	 * @return bool Need to render home path part (true) or not (false)
	 */
	protected function needToRenderHome() {
		return (!is_null($this->home_page_text) && !(count($this->page->getParents()) == 0 && $this->page->getIndex()));
	}

}

?>