<?php
class Model{
	protected $db;
	protected $table_name;
	protected $is_connect;
	public function __construct(){
		$this->db	= new database();
		$this->is_connect	= $this->db->connect(STAGE);
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
		$sql	= $this->_createInsertSql($params);
		return $this->db->execQuery($sql, $params);
	}
	public function setData($updates, $conditions){
		$sql	= $this->_createUpdateSql($updates, $conditions);
		$params	= array_merge($updates, $conditions);
		return $this->db->execQuery($sql, $params);
	}
	public function deleteData($params){
		$sql	= $this->_createDeleteSql($params);
		return $this->db->execQuery($sql, $params);
	}
	public function getDatabase(){
		return $this->db;
	}
	public function getLastInsertId(){
		$sql	= "SELECT last_insert_id() as id ";
		$this->db->execQuery($sql);
		$res	= $this->db->fetch();
		return $res ? $res['id'] : null;
	}
	public function getColumnList(){
		return $this->db->getColumnList($this->_getTableName());
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
	protected function _getTableName(){
		if(!empty($this->table_name))	return $this->table_name;
		$table_name = "";
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
