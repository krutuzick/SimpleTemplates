<?php
namespace simtpl\controls;
use \simtpl\exceptions;

/**
 * Base control class
 */
class base {
	/**
	 * @var array Html attributes for a wrapper tag of control
	 */
	private $attributes = array();

	/**
	 * Set html attributes for a wrapper tag of control
	 * @param array $attr
	 */
	public function addAttributes($attr) {
		foreach($attr as $attr_name => $attr_value) {
			if(!isset($this->attributes[$attr_name])) {
				$this->attributes[$attr_name] = array();
			}
			$this->attributes[$attr_name][] = $attr_value;
		}
	}

	/**
	 * @param string $value_inner_quotes Replace for value quotes
	 * @param string $value_quotes Quotes for each attribute value
	 * @return string String of html tag attributes
	 */
	protected function getAttributesHtml($value_inner_quotes = "'", $value_quotes='"') {
		$attributes_html = "";
		foreach($this->attributes as $attr_name => $attr_values) {
			$attr_values = is_array($attr_values) ? $attr_values : array($attr_values);
			foreach($attr_values as $i => $attr_value) {
				if($attr_value == '') {
					unset($attr_values[$i]);
				}
			}
			$value_string = join(' ', $attr_values);
			$value_string = str_replace($value_quotes, $value_inner_quotes, $value_string);
			$attributes_html .= $attr_name . "=" . $value_quotes . $value_string . $value_quotes . " ";
		}
		return trim($attributes_html);
	}

	/**
	 * @return string Full path to template file
	 */
	protected function getTemplatePath() {
		$relative_path = str_replace("\\", "/", substr(get_class($this), strlen("\\simtpl\\") - 1));
		return \simtpl\application::getRootPath() . "/templates/{$relative_path}.php";
	}

	/**
	 * @return string Rendered control
	 */
	public function __toString() {
		$content = "";
		$template = $this->getTemplatePath();
		if(file_exists($template)) {
			ob_start();
			include $template;
			$content = ob_get_clean();
		}
		return $content;
	}


}

?>