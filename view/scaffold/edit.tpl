<h2><a href="<?php Html::path($this->controller_name . "/"); ?>"><?php h($this->model_name); ?></a></h2>
<form action="<?php Html::path($this->controller_name . "/edit/" . $data['id']); ?>" method="post">
<table class="table">
	<?php foreach($data as $key => $val): ?>
	<?php if($key == $this->ScaffoldModel->created || $key == $this->ScaffoldModel->modified) continue; ?>
	<tr>
		<th><?php h($key); ?></th>
		<td><input type="text" name="<?php h($key); ?>" value="<?php h($val); ?>"></td>
	</tr>
	<?php endforeach; ?>
	<tr>
		<td colspan="2"><input type="submit" value="EDIT"></td>
</table>
</form>
