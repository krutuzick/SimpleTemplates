<?
$this->addAttributes(array('class' => $this->type));
$this->addAttributes(array('class' => $this->getFullColorClass()));
?><span <?= $this->getAttributesHtml(); ?>><?= $this->content; ?></span>