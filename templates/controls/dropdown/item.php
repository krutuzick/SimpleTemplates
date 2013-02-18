<? if($this->is_divider) { ?>
<li class="divider">&nbsp;</li>
<?
} else { ?>
<li <?= $this->getAttributesHtml(); ?>>
	<a tabindex="-1" href="<?= $this->link; ?>"><?= $this->caption; ?></a>
	<? echo $this->submenu; ?>
</li>
<?}