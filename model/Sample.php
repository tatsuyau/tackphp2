<?php
class Sample extends Model{
	// columnsを定義しておくと、自動的にInnoDBテーブルが作成されます。
	protected $columns = array(
		'id'	=> "int(11) PRIMARY KEY AUTO_INCREMENT",
		'name'	=> "varchar(225)",
		'created'	=> 'datetime',
		'modified'	=> 'datetime',
	);
}
