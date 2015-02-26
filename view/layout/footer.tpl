<?php if(DEBUG_MODE): ?>
<!-- debug -->
<div class="container">
	<hr>
	<h3>Debug</h3>
	<?php dump($this->debug_list); ?>
	<h3>SQL</h3>
	<?php dump(SqlLog::getList()); ?>
	<hr>
</div>
<!-- //debug -->
<?php endif; ?>