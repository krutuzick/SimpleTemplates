<?php
namespace simtpl;

/**
 * Structure page class
 */
class page {
	const CONFIG_NODE_NAME = 'page';
	const CONFIG_ATTRIBUTE_NAME = 'name';
	const CONFIG_ATTRIBUTE_INDEX = 'index';
	const CONFIG_META = 'meta';
	const CONFIG_META_TITLE = 'title';
	const CONFIG_META_DESCRIPTION = 'description';
	const CONFIG_META_KEYWORDS = 'keywords';
	const CONFIG_CAPTION = 'caption';
	const CONFIG_REDIRECT = 'redirect';
	const CONFIG_TEMPLATE = 'template';
	const CONFIG_CSSCLASS = 'cssclass';
	const CONFIG_RESOURCES = 'resources';
	const CONFIG_RESOURCES_JS = 'js';
	const CONFIG_RESOURCES_CSS = 'css';
	const CONFIG_RESOURCES_ITEM = 'item';
	const CONFIG_CHILDREN = 'children';

	const META_KEY_ALL = 0;
	const META_KEY_TITLE = 'title';
	const META_KEY_DESCRIPTION = 'description';
	const META_KEY_KEYWORDS = 'keywords';
	const RESOURCES_KEY_ALL = 0;
	const RESOURCES_KEY_JS = 'js';
	const RESOURCES_KEY_CSS = 'css';

	protected $xmlConfig;
	protected $parents = array();

	protected $name;
	protected $index = false;
	protected $meta = array('title' => '', 'description' => '', 'keywords' => '');
	protected $caption;
	protected $redirect = false;
	protected $template;
	protected $cssclass = '';
	protected $resources = array('js' => array(), 'css' => array());
	protected $children = array();
	protected $url;

	/**
	 * @param \SimpleXMLElement $xmlNode Configuration XML node
	 * @param array $parents Array of \simtpl\page objects - all parents from upper to lower
	 * @throws exceptions\source
	 */
	public function __construct($xmlNode, &$parents = array()) {
		if($xmlNode instanceof \SimpleXMLElement == false) {
			throw new exceptions\source("Page object was instanced with incorrect parameter");
		}
		$this->parents = $parents;
		$this->xmlConfig = $xmlNode;
		$this->parseConfig();
	}

	/**
	 * Parse xml config and this object with data
	 */
	protected function parseConfig() {
		$this->parseName();
		$this->parseIndex();
		$this->parseCaption();
		$this->parseMeta();
		$this->parseRedirect();
		$this->parseTemplate();
		$this->parseCssClass();
		$this->parseResources();
		$this->parseChildren();
	}

	/**
	 * Fill page name from xml config. Page name defined in "name" attribute and required for all pages
	 * @throws exceptions\source
	 */
	private function parseName() {
		$mainAttributes = $this->xmlConfig->attributes();
		$this->name = $mainAttributes[self::CONFIG_ATTRIBUTE_NAME];
		if($this->name == "") {
			throw new exceptions\source("Page in structure does not have required attribute " . self::CONFIG_ATTRIBUTE_NAME);
		}
	}

	/**
	 * Define whether this page is default from xml config
	 */
	private function parseIndex() {
		$mainAttributes = $this->xmlConfig->attributes();
		$this->index = (intval($mainAttributes[self::CONFIG_ATTRIBUTE_INDEX]) == 1);
	}

	/**
	 * Fill page caption from xml config
	 */
	private function parseCaption() {
		$caption = $this->xmlConfig->xpath(self::CONFIG_CAPTION);
		if(count($caption) > 0 && (string)$caption[0] != "") {
			$this->caption = (string)$caption[0];
		} else {
			$this->caption = $this->name;
		}
	}

	/**
	 * Fill META from xml config
	 */
	private function parseMeta() {
		$meta = $this->xmlConfig->xpath(self::CONFIG_META);
		if(count($meta) != 0) {
			$metaNode = $meta[0];
			$title = $metaNode->xpath(self::CONFIG_META_TITLE);
			$description = $metaNode->xpath(self::CONFIG_META_DESCRIPTION);
			$keywords = $metaNode->xpath(self::CONFIG_META_KEYWORDS);
			$this->meta['title'] = (count($title) > 0 && (string)$title[0] != "") ? (string)$title[0] : $this->caption;
			$this->meta['description'] = (count($description) > 0 && (string)$description[0] != "") ? (string)$description[0] : "";
			$this->meta['keywords'] = (count($keywords) > 0 && (string)$keywords[0] != "") ? (string)$keywords[0] : "";
		}
	}

	/**
	 * Fill redirect string from xml config (or false if config is empty)
	 */
	private function parseRedirect() {
		$redirect = $this->xmlConfig->xpath(self::CONFIG_REDIRECT);
		$this->redirect = (count($redirect) > 0 && (string)$redirect[0] != "") ? (string)$redirect[0] : false;
	}

	/**
	 * Fill path to template file from xml config (or default if config is empty)
	 */
	private function parseTemplate() {
		$template = $this->xmlConfig->xpath(self::CONFIG_TEMPLATE);
		$this->template = (count($template) > 0 && (string)$template[0] != "") ? (string)$template[0] : $this->getDefaultTemplate();
	}

	/**
	 * Fill extra css classes from xml config
	 */
	private function parseCssClass() {
		$css_class = $this->xmlConfig->xpath(self::CONFIG_TEMPLATE);
		$this->cssclass = (count($css_class) > 0 && (string)$css_class[0] != "") ? (string)$css_class[0] : "";
	}

	/**
	 * Fill resources array from xml config
	 */
	private function parseResources() {
		$resources = $this->xmlConfig->xpath(self::CONFIG_RESOURCES);
		if(count($resources) != 0) {
			$resourcesNode = $resources[0];
			$js = $resourcesNode->xpath(self::CONFIG_RESOURCES_JS);
			if(count($js) > 0) {
				$jsNode = $js[0];
				$jsNodeItems = $jsNode->xpath(self::CONFIG_RESOURCES_ITEM);
				foreach($jsNodeItems as $jsNodeItem) {
					if((string)$jsNodeItem != "") {
						$this->resources['js'][] = (string)$jsNodeItem;
					}
				}
			}
			$css = $resourcesNode->xpath(self::CONFIG_RESOURCES_CSS);
			if(count($css) > 0) {
				$cssNode = $css[0];
				$cssNodeItems = $cssNode->xpath(self::CONFIG_RESOURCES_ITEM);
				foreach($cssNodeItems as $cssNodeItem) {
					if((string)$cssNodeItem != "") {
						$this->resources['css'][] = (string)$cssNodeItem;
					}
				}
			}
		}
	}

	/**
	 * Fill children objects from xml config
	 */
	private function parseChildren() {
		$children = $this->xmlConfig->xpath(self::CONFIG_CHILDREN);
		if(count($children) > 0) {
			$childrenNode = $children[0];
			$pages = $childrenNode->xpath(self::CONFIG_NODE_NAME);
			$parents_for_children = $this->getParents();
			$parents_for_children[] = & $this;
			foreach($pages as $pageNode) {
				$this->children[] = new page($pageNode, $parents_for_children);
			}
		}
	}

	/**
	 * @return string Path to default template file in templates/<config option templates/pagesfolder> folder
	 */
	private function getDefaultTemplate() {
		$path = trim($this->getUrl(), '/');
		if($path == "") {
			$path = $this->getName();
		}
		return $path . ".php";
	}

	/**
	 * @return string URL to this page without domain, with leading and tailing slashes
	 * @throws exceptions\source
	 */
	public function getUrl() {
		if(empty($this->url)) {
			$this->url = "/";
			foreach($this->parents as $parent) {
				if($parent instanceof page) {
					$this->url .= $parent->getName() . "/";
				} else {
					throw new exceptions\source("One of page's {$this->getName()} parents is not object of page");
				}
			}
		}
		return $this->url;
	}

	/**
	 * @return string Caption of page
	 */
	public function getCaption() {
		return $this->caption;
	}

	/**
	 * @return array Array of \simtpl\page objects - children of this page
	 */
	public function getChildren() {
		return $this->children;
	}

	/**
	 * @return string Extra css classes for menu item for this page
	 */
	public function getCssclass() {
		return $this->cssclass;
	}

	/**
	 * @return bool Whether this page is default or not
	 */
	public function getIndex() {
		return $this->index;
	}

	/**
	 * @param int $type const from \simtpl\page META_KEY_*
	 * @return array|string Contents of specified META tag, or array with all of them if META_KEY_ALL passed
	 * @throws exceptions\source
	 */
	public function getMeta($type = self::META_KEY_ALL) {
		if($type === self::META_KEY_ALL) {
			return $this->meta;
		}
		if(isset($this->meta[$type])) {
			return $this->meta[$type];
		} else {
			throw new exceptions\source("Invalid META key: {$type}");
		}
	}

	/**
	 * @return string Name of page, which forms it's URL part and used in default template selection
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return array Array of \simtpl\page objects - parents of this page
	 */
	public function getParents() {
		return $this->parents;
	}

	/**
	 * @return string|bool URL to redirect from this page or boolean FALSE
	 */
	public function getRedirect() {
		return $this->redirect;
	}

	/**
	 * @param int $type const from \simtpl\page RESOURCES_KEY_*
	 * @return array Array of strings - URLs of specified resources needed to include on this page (or all resources if RESOURCES_KEY_ALL passed)
	 * @throws exceptions\source
	 */
	public function getResources($type = self::RESOURCES_KEY_ALL) {
		if($type === self::RESOURCES_KEY_ALL) {
			return $this->resources;
		}
		if(isset($this->resources[$type])) {
			return $this->resources[$type];
		} else {
			throw new exceptions\source("Invalid resources key: {$type}");
		}
	}

	/**
	 * @return string Path to template file in templates/<config option templates/pagesfolder> folder
	 */
	public function getTemplate() {
		return $this->template;
	}

}

?>