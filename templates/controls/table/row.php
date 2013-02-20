<?
$this->addAttributes(array('class' => $this->color));
?><tr <?= $this->getAttributesHtml(); ?>>
	<? foreach($this->cells as &$cell) {?>
	<?= $cell; ?>
	<?}?>
</tr>