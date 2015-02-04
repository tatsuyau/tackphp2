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
				<li><a href="<?php Html::path("main/index"); ?>">LINK1</a></li>
				<li><a href="<?php Html::path("main/view/hello"); ?>">LINK2</a></li>
			</ul>
		</div>
	</div>
</nav>

