<? if(empty($this->items) && $this->hide_if_empty) {
	echo "";
} else {
	if($this->visible_initial) $this->addAttributes(array('class' => 'simtpl-dropdown-visible'));
?>
<ul <?= $this->getAttributesHtml(); ?>>
<?
	foreach($this->items as &$dropdown_item) {
		echo $dropdown_item;
	}
?>
</ul>
<? } ?>