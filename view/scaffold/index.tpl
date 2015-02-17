<h2><?php h($this->model_name); ?> List</h2>
<p><a href="<?php Html::path($this->controller_name . "/add"); ?>">Create Item</a></p>
<table class="table table-striped">
	<tr>
	<?php foreach($column_list as $val): ?>
	<th><?php h($val); ?></th>
	<?php endforeach; ?>
	<th>Action</th>
	</tr>

	<?php foreach($list as $data): ?>
	<tr>
		<?php foreach($data as $val): ?>
		<td><?php h($val); ?></td>
		<?php endforeach; ?>
		<td>
		<a style="margin-right:5px;" href="<?php Html::path($this->controller_name . "/view/" . $data[$primary_key]); ?>">View</a>
		<a style="margin-right:5px;" href="<?php Html::path($this->controller_name . "/edit/" . $data[$primary_key]); ?>">Edit</a>
		<a style="margin-right:5px;" href="<?php Html::path($this->controller_name . "/delete/" . $data[$primary_key]); ?>">Delete</a>
		</td>
	</tr>
	<?php endforeach; ?>
</table>
