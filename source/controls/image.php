<?php
namespace simtpl\controls;

/**
 * Image control
 */
class image extends base {
	const TYPE_DEFAULT = '';
	const TYPE_ROUNDED = 'img-rounded';
	const TYPE_CIRCLE = 'img-circle';
	const TYPE_POLAROID = 'img-polaroid';

	protected $type;
	protected $src;
	protected $width = '';
	protected $height = '';

	public function __construct($src, $type = self::TYPE_DEFAULT, $width = '', $height = ''){
		$this->src = $src;
		$this->type = $type;
		$this->addAttributes(array('class' => 'simtpl-image'));
		if($width != '') {
			$this->width = $width;
		}
		if($height != '') {
			$this->height = $height;
		}
	}

	public function setSrc($src) {
		$this->src = $src;
	}

	public function setType($type) {
		$this->type = $type;
	}

	public function setHeight($height) {
		if($height != '') {
			$this->height = $height;
		}
	}

	public function setWidth($width) {
		if($width != '') {
			$this->width = $width;
		}
	}
}

?>