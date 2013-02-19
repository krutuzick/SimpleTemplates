<? if($this->needToRender()) { ?>
<ul <?= $this->getAttributesHtml() ?>>
	<? if($this->needToRenderHome()) {?>
	<li><? if(!is_null($this->home_page_icon)) echo "{$this->home_page_icon} "; ?><a href="/"><?= $this->home_page_text; ?></a> <span class="divider"><?= $this->separator; ?></span></li>
	<?}
	foreach($this->page->getParents() as $page_parent) {?>
	<li><a href="<?= $page_parent->getUrl(true); ?>"><?= $page_parent->getCaption(); ?></a> <span class="divider"><?= $this->separator; ?></span></li>
	<?}?>
	<li class="active"><?= $this->page->getCaption(); ?></li>
</ul>
<?}?>