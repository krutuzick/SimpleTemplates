<!DOCTYPE html>
<html>
<head>
	<title><?= $page->getMeta(\simtpl\page::META_KEY_TITLE) ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<meta name="description" content="<?= $page->getMeta(\simtpl\page::META_KEY_DESCRIPTION) ?>"/>
	<meta name="keywords" content="<?= $page->getMeta(\simtpl\page::META_KEY_KEYWORDS) ?>"/>
	<meta name="robots" content="noindex, nofollow">

	<link rel="stylesheet" href="/css/normalize.css"/>
	<link rel="stylesheet" href="/css/bootstrap.min.css"/>
	<?= $this->getControlsResource(\simtpl\handlers\http::RESOURCE_CSS); ?>
<? foreach($page->getResources(\simtpl\page::RESOURCES_KEY_CSS) as $cssLink) { ?>
	<link rel="stylesheet" href="<?= $cssLink ?>"/>
<? } ?>

	<script type="text/javascript" src="http://yandex.st/jquery/1.9.0/jquery.min.js"></script>
	<script type="text/javascript" src="http://code.jquery.com/jquery-migrate-1.1.0.js"></script>
<!--	<script type="text/javascript" src="http://code.jquery.com/jquery-migrate-1.1.0.min.js"></script> -->
	<script type="text/javascript" src="/js/bootstrap.min.js" ></script>
	<?= $this->getControlsResource(\simtpl\handlers\http::RESOURCE_JS); ?>
<? foreach($page->getResources(\simtpl\page::RESOURCES_KEY_JS) as $jsLink) { ?>
	<script type="text/javascript" src="<?= $jsLink ?>"></script>
<? } ?>

</head>
<body id="body">
<?
	$menu = new \simtpl\controls\menu($this->configuration->getStructure(), $this->page);
	echo $menu;
?>
	<div class="container">
	<? include($this->getPageTemplatePath($page)); ?>
	</div>
</body>
</html>