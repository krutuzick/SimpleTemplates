<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?= $page->getMeta(\simtpl\page::META_KEY_TITLE) ?></title>

	<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
</head>
<body id="body">
	<? include($this->getPageTemplatePath($page)); ?>
</div>
</body>
</html>