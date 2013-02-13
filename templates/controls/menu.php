<style>
	body {
		padding-top: 40px;
	}
</style>
<div class="navbar navbar-fixed-top<?= ($this->inverted_color) ? " navbar-inverse" : "";?>">
	<div class="navbar-inner">
		<div class="container">
			<!-- .btn-navbar is used as the toggle for collapsed navbar content -->
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			<? if(is_array($this->brand)) {?>
			<!-- Be sure to leave the brand out there if you want it shown -->
			<a class="brand" href="<?=$this->brand['url'];?>"><?=$this->brand['title'];?></a>
			<?}?>
			<!-- Everything you want hidden at 940px or less, place within here -->
			<div class="nav-collapse collapse">
				<!-- .nav, .navbar-search, .navbar-form, etc -->
				<ul class="nav"><?
				if($this->separators) {
					?><li class="divider-vertical"></li><?
				}
				foreach($this->structure as &$page) {
					if($page instanceof \simtpl\page) {
						$class = "simtpl-menu-link-" . $page->getName();
						if($page === $this->current_page || in_array($page, $this->current_page->getParents(), true)) {
							$class .= " active";
						}
						?><li class="<?=$class;?>"><a href="<?=$page->getUrl();?>"><?=$page->getCaption();?></a></li><?
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
	</div>
</div>