<h2><a href="<?php Html::path("/" . $this->controller_name . "/"); ?>"><?php h($this->model_name); ?></a></h2>
<form action="<?php Html::path("/" . $this->controller_name . "/add"); ?>" method="post">
<table class="table">
<?php foreach($column_list as $val): ?>
<?php if($val == $this->ScaffoldModel->created || $val == $this->ScaffoldModel->modified) continue; ?>
<tr>
	<th><?php h($val); ?></th>
	<td><input type="text" name="<?php h($val); ?>"></td>
</tr>
<?php endforeach; ?>
<tr>
	<td colspan="2"><input type="submit" value="add"></td>
</tr>
</table>
