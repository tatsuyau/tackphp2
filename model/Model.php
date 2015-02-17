<?php
class Model{
	public $is_connect;
	public $created = "created";
	public $modified= "modified";
	protected $db;
	protected $table_name;
	public function __construct(){
		$this->db	= database::getInstance(STAGE);
		$this->is_connect	= $this->db->is_connect;
	}
	public function getList($params=array()){
		$sql	= $this->_createSelectSql($params);
		$this->db->execQuery($sql, $params);
		$res	= $this->db->fetchAll();
		return $res ? $res : array();
	}
	public function getData($params=array()){
		$sql	= $this->_createSelectSql($params);
		$this->db->execQuery($sql, $params);
		$res	= $this->db->fetch();
		return $res ? $res : array();
	}
	public function addData($params){
		if($this->created){
			$params[$this->created]	= (!empty($params[$this->created])) ? $params[$this->created] : date('Y-m-d H:i:s');
		}
		if($this->modified){
			$params[$this->modified]= (!empty($params[$this->modified])) ? $params[$this->modified] : date('Y-m-d H:i:s');
		}
		$sql	= $this->_createInsertSql($params);
		$res	= $this->db->execQuery($sql, $params);
		return $res;
	}
	public function setData($updates, $conditions){
		if($this->modified){
			$updates[$this->modified]	= (!empty($updates[$this->modified])) ? $updates[$this->modified] : date('Y-m-d H:i:s');
		}
		$sql	= $this->_createUpdateSql($updates, $conditions);
		$params	= array_merge($updates, $conditions);
		$res	= $this->db->execQuery($sql, $params);
		return $res;
	}
	public function deleteData($params){
		$sql	= $this->_createDeleteSql($params);
		return $this->db->execQuery($sql, $params);
	}
	public function getDatabase(){
		return $this->db;
	}
	public function getLastInsertId(){
		return $this->db->getLastInsertId();
	}
	public function getColumnList(){
		return $this->db->getColumnList($this->_getTableName());
	}
	public function beginTransaction(){
		return $this->db->beginTransaction();
	}
	public function commit(){
		return $this->db->commit();
	}
	public function rollback(){
		return $this->db->rollback();
	}
	public function hasTable($table_name=null){
		if(!$table_name)	$table_name	= $this->_getTableName();
		$db_info	= $this->db->getInfo();
		$sql	= "SHOW TABLES FROM " . $db_info['dbname'] . " LIKE '" . $table_name . "'";
		$this->db->execQuery($sql);
		return $this->db->fetch() ? true : false;
	}
	public function createTable(){
		if(empty($this->columns))	return ;
		$sql	= "CREATE TABLE IF NOT EXISTS " . $this->_getTableName() . " ( ";
		$i	= 0;
		foreach($this->columns as $key => $val){
			if($i)	$sql .= ", ";
			$sql	.= $key . " " . $val;
			$i++;
		}
		$sql	.= ") engine=InnoDB ";
		$res	= $this->db->execQuery($sql);
		return $res;
	}
	public function getTableName(){
		return $this->_getTableName();
	}
	protected function _getTableName(){
		if(!empty($this->table_name))	return $this->table_name;
		$db_info = $this->db->getInfo();
		$table_name = $db_info['table_prefix'];
		$class_name = get_class($this);
                preg_match_all("/[A-Z][a-z]+/",$class_name,$matches_list);
                foreach($matches_list[0] as $key => $val){
                        if($key)        $table_name .= '_';
                        $table_name     .= strtolower($val);
                }
		return $table_name;
	}
	protected function _createSelectSql($p){
		$sql	= "SELECT * FROM " . $this->_getTableName() . " ";
		$sql	.= $this->__createConditions($p);
		return $sql;
	}
	protected function _createUpdateSql($updates, $conditions){
		$sql	= "UPDATE " . $this->_getTableName() . " ";
		$sql	.= $this->__createUpdates($updates);
		$sql	.= $this->__createConditions($conditions);
		return $sql;
	}
	protected function _createInsertSql($p){
		$sql	= "INSERT INTO " . $this->_getTableName() . " ";
		$sql	.= "( ";
		$i	= 0;
		foreach($p as $key => $val){
			if($i)	$sql	.= ", ";
			$sql	.= $key;
			$i++;
		}
		$sql	.= ") VALUES( ";
		$i	= 0;
		foreach($p as $key => $val){
			if($i)	$sql	.= ", ";
			$sql	.= ":" . $key;
			$i++;
		}
		$sql	.= ") ";
		return $sql;
	}
	protected function _createDeleteSql($p){
		$sql	= "DELETE FROM " . $this->_getTableName() . " ";
		$sql	.= $this->__createConditions($p);
		return $sql;
	}
	private function __createConditions($p){
		$sql	= "";
		if(!$p)	return $sql;
		$i	= 0;
		foreach($p as $key => $val){
			if(!$i){
				$sql	.= " WHERE ";
			}else{
				$sql	.= " AND ";
			}
			$sql	.= $key . "=:" . $key;
			$i++;
		}
		return $sql;
	}
	private function __createUpdates($p){
		$sql	= " SET ";
		$i	= 0;
		foreach($p as $key => $val){
			if($i)	$sql	.= ", ";
			$sql	.= $key . "=:" . $key;
			$i++;
		}
		return $sql;
	}
}
