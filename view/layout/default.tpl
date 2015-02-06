<!DOCTYPE html>
<html lang="ja">
<head>
	<title><?php h(APP_NAME); ?></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<link rel="stylesheet" href="<?php Html::path("/css/style.css"); ?>">
	<script src="<?php Html::path("/js/client.js"); ?>"></script>
</head>
<body>

<?php require_once(LAYOUT_DIR."header.tpl"); ?>

<div class="container">
	<?php require_once($view_file); ?>
</div>

<?php require_once(LAYOUT_DIR."footer.tpl"); ?>

</body>
</html>
