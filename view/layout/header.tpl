<nav class="navbar navbar-default">
	<div class="container">
		<div class="navbar-header">
			<button class="navbar-toggle" data-toggle="collapse" data-target=".target">
				<span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?php Html::path(); ?>"><?php h(APP_NAME); ?></a>
		</div>

		<div class="collapse navbar-collapse target">
			<ul class="nav navbar-nav">
				<li><a href="<?php Html::path("sample"); ?>">scaffold</a></li>
				<li><a href="http://tackphp.jp/" target="_blank">tackphp.jp</a></li>
				<li><a href="https://github.com/tatsuyau/tackphp2" target="_blank">github</a></li>
			</ul>
		</div>
	</div>
</nav>
