<div <?= $this->getAttributesHtml(); ?>>
	<? if($this->closable) { ?>
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<? }?>
	<?= $this->content; ?>
</div>