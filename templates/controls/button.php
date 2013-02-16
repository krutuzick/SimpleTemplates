<?
$this->addAttributes(array('class' => $this->type));
$this->addAttributes(array('class' => $this->size));
if($this->is_disabled) {
	$this->addAttributes(array(
		'class' => 'disabled',
		'disabled' => 'disabled',
	));
}
if(!is_null($this->title)) {
	$this->addAttributes(array('title' => $this->title));
}
/*
protected $dropdown;
*/
$tag_name = "a";
$tag_content = "";
switch($this->tag_type) {
	case \simtpl\controls\button::TAG_TYPE_A:
		$this->addAttributes(array('href' => $this->link));
		if(!is_null($this->icon)) {
			$this->caption = "{$this->icon} {$this->caption}";
		}
		$tag_name = "a";
		$tag_content = $this->caption;
		break;
	case \simtpl\controls\button::TAG_TYPE_BUTTON:
		$this->addAttributes(array('type' => 'button'));
		if(!is_null($this->icon)) {
			$this->caption = "{$this->icon} {$this->caption}";
		}
		$tag_name = "button";
		$tag_content = $this->caption;
		break;
	case \simtpl\controls\button::TAG_TYPE_INPUT_BUTTON:
		$this->addAttributes(array('type' => 'button'));
		$this->addAttributes(array('value' => $this->caption));
		$tag_name = "input";
		break;
	case \simtpl\controls\button::TAG_TYPE_INPUT_SUBMIT:
		$this->addAttributes(array('type' => 'submit'));
		$this->addAttributes(array('value' => $this->caption));
		$tag_name = "input";
		break;
}

if(is_null($this->dropdown)) {
	echo "<{$tag_name} " . $this->getAttributesHtml() . ">{$tag_content}</{$tag_name}>";
} else {
	echo "<div class=\"btn-group\">";
	if($this->separate_dropdown) {
		echo "<{$tag_name} " . $this->getAttributesHtml() . ">{$tag_content}</{$tag_name}>";
		$toggle = new \simtpl\controls\button("<span class=\"caret\"></span>", null, null, $this->type, $this->size, null, \simtpl\controls\button::TAG_TYPE_A);
		$toggle->addAttributes(array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown'));
		if($this->is_disabled) {
			$toggle->setIsDisabled();
		}
		echo $toggle;
	} else {
		$this->addAttributes(array('class' => 'dropdown-toggle'));
		$this->addAttributes(array('data-toggle' => 'dropdown'));
		echo "<{$tag_name} " . $this->getAttributesHtml() . ">{$tag_content} <span class=\"caret\"></span></{$tag_name}>";
	}
	echo $this->dropdown;
	echo "</div>";
}
?>