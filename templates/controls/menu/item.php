<li <?= $this->getAttributesHtml(); ?>>
	<a class="dropdown-toggle" href="<?= $this->page->getUrl(); ?>"><?= $this->page->getCaption(); ?></a>
	<? echo $this->submenu; ?>
</li>