<?php
$this->addAttributes(array('class' => $this->type));
$this->addAttributes(array('src' => $this->src));
if($this->width != '') {
	$this->addAttributes(array('width' => $this->width));
}
if($this->height != '') {
	$this->addAttributes(array('height' => $this->height));
}
?><img <?= $this->getAttributesHtml(); ?>>