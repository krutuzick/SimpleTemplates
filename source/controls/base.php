<?php
namespace simtpl\controls;
use \simtpl\exceptions;

/**
 * Base control class
 */
class base {

	/**
	 * @return string Full path to template file
	 */
	protected function getTemplatePath() {
		$relative_path = str_replace("\\", "/", substr(__CLASS__, strlen("\\simtpl\\") - 1));
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