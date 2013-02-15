<? if(empty($this->items) && $this->hide_if_empty) {
	echo "";
} else { ?>
<ul <?= $this->getAttributesHtml(); ?>>
<?
	foreach($this->items as &$dropdown_item) {
		echo $dropdown_item;
	}
?>
</ul>
<? } ?>