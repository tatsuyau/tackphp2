<?php
class Model{
	protected $db;
	public function __construct(){
		$this->db	= new database();
		$this->db->connect(STAGE);
	}
	public function getList($params=array()){
		$sql	= $this->_cteateSelectSql($params);
	}
	public function getDatabase(){
		return $this->db;
	}
	public function beginTransaction(){
		$this->db->beginTransaction();
	}
	public function commit(){
		$this->db->commit();
	}
	public function rollback(){
		$this->db->rollback();
	}
}
