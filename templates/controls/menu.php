<style>
	body {
		padding-top: 40px;
	}
</style>
<div class="simtpl-menu navbar navbar-fixed-top<?= ($this->inverted_color) ? " navbar-inverse" : "";?>">
	<div class="navbar-inner">
		<div class="container">
			<? if(is_array($this->brand)) {?>
				<a class="brand" href="<?=$this->brand['url'];?>"><?=$this->brand['title'];?></a>
			<?}?>
			<ul class="nav"><?
			if($this->separators) {
				?><li class="divider-vertical"></li><?
			}
			foreach($this->structure as &$page) {
				if($page instanceof \simtpl\page) {
					if($page->getHiddenFromMenu()) continue;
					$class = "dropdown simtpl-menu-link-" . $page->getName();
					if($page === $this->current_page || in_array($page, $this->current_page->getParents(), true)) {
						$class .= " active";
					}
					?><li class="<?=$class;?>">
						<a class="dropdown-toggle" href="<?=$page->getUrl();?>"><?=$page->getCaption();?></a>
						<? echo drawChildren($page->getChildren()); ?>
					</li><?
					if($this->separators) {
						?><li class="divider-vertical"></li><?
					}
				} else {
					throw new \simtpl\exceptions\source("Incorrect parameter for control 'menu' creation");
				}
			}
			?></ul>
		</div>
	</div>
</div><?
/**
 * @param array $children Array of \simtpl\page - page children
 * @return string HTML of children submenu
 */
function drawChildren(&$children) {
	if(count($children) == 0) return "";
	$children_html = "";
	foreach($children as &$childPage) {
		if($childPage->getHiddenFromMenu()) continue;
		$children_children_html = drawChildren($childPage->getChildren());
		$children_html .= ($children_children_html == "") ? "<li>" : "<li class=\"dropdown-submenu\">";
		$children_html .= "<a tabindex=\"-1\" href=\"{$childPage->getUrl()}\">{$childPage->getCaption()}</a>";
		$children_html .= $children_children_html;
		$children_html .= "</li>";
	}
	return ($children_html != "") ? "<ul class=\"dropdown-menu\">{$children_html}</ul>" : "";
}
?>