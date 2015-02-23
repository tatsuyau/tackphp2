<!DOCTYPE html>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="<?php h(PROJECT_DESCRIPTION); ?>" />
<meta name="keyword" content="<?php h(PROJECT_KEYWORDS); ?>">
<meta name="robots" content="index,follow,noarchive" />
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="<?php Html::path("/css/style.css"); ?>">
<script src="<?php Html::path('/js/client.js?' . date('s')); ?>"></script>
<title><?php h(PROJECT_TITLE); ?></title>

<!-- body -->

<header>
	<?php require_once(LAYOUT_DIR."header.tpl"); ?>
</header>

<div class="container">
	<?php require_once($view_file); ?>
</div>

<footer>
	<?php require_once(LAYOUT_DIR."footer.tpl"); ?>
</footer>

<!-- //body -->

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<!--[if lt IE 9]>
<script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</html>