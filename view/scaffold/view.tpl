<h2><a href="<?php Html::path("/" . $this->controller_name . "/"); ?>"><?php h($this->model_name); ?></a></h2>

<table class="table">
<?php foreach($data as $key => $val): ?>
<tr>
	<th><?php h($key); ?></th>
	<td><?php h($val); ?></td>
</tr>
<?php endforeach; ?>
</table>
