<?
if($this->striped) {
	$this->addAttributes(array('class' => 'table-striped'));
}
if($this->bordered) {
	$this->addAttributes(array('class' => 'table-bordered'));
}
if($this->hover) {
	$this->addAttributes(array('class' => 'table-hover'));
}
if($this->compact) {
	$this->addAttributes(array('class' => 'table-condensed'));
}
if(is_null($this->header) && count($this->rows) == 1 && !$this->bordered) {
	$this->rows[0]->addAttributes(array('class' => 'simtpl-row-noborder'));
}
?><table <?= $this->getAttributesHtml(); ?>>
	<? if(!is_null($this->header)) {?>
	<thead>
		<?= $this->header; ?>
	</thead>
	<?}?>
	<tbody>
		<? foreach($this->rows as &$row) {?>
		<?= $row; ?>
		<?}?>
	</tbody>
</table>