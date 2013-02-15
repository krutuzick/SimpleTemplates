<?
if($this->inverted_color) {
	$this->addAttributes(array('class' => 'navbar-inverse'));
}
if($this->fixed_top_style) {
	$this->addAttributes(array('class' => 'navbar-fixed-top'));
?>
<style>
	body {
		padding-top: 40px;
	}
</style>
<?
}
?>
<div <?= $this->getAttributesHtml(); ?>>
	<div class="navbar-inner">
		<div class="container"><?
			if(is_array($this->brand)) {
				echo "<a class=\"brand\" href=\"{$this->brand['url']}\">{$this->brand['title']}</a>";
			} ?>
			<ul class="nav">
			<?
				if($this->separators) {
					echo "<li class=\"divider-vertical\"></li>";
				}
				foreach($this->items as &$menu_item) {
					echo $menu_item;
					if($this->separators) {
						echo "<li class=\"divider-vertical\"></li>";
					}
				}
			?>
			</ul>
		</div>
	</div>
</div>