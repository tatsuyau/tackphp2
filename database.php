<?php
// Using PDO
class database{
	protected $config = array(
		'develop' => array(
			'type'	=> 'mysql',
			'dbname'=> 'tackphp',
			'host'	=> 'localhost',
			'user'	=> 'root',
			'password' => 'vagrant',
			'encoding' => 'utf8',
		),
	);
	protected $dbh;
	protected $stmt;
	public function connect($config_key){
		if(empty($this->config[$config_key]))	return false;
		$config	= $this->config[$config_key];
		try{
			$dsn	= $config['type'] . ":host=" . $config['host'] . ";dbname=" . $config['dbname'];
			$dbh	= new PDO($dsn, $config['user'], $config['password']);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$res	= $dbh->exec("SET NAMES " . $config['encoding']);
			$this->dbh	= $dbh;
		}catch(PDOException $e){
			throw new Exception($e->getMessage());
		}
	}
	public function execQuery($sql, $params=array()){
		$params	= $this->_optimize($params);
		try{
			$stmt	= $this->dbh->prepare($sql);
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			$res	= $stmt->execute($params);
		}catch(PDOException $e){
			throw new Exception($e->getMessage());
		}
		$this->stmt	= $stmt;
		return $res;
	}
	public function fetchAll(){
		return $this->stmt->fetchAll();
	}
	public function fetch(){
		return $this->stmt->fetch();
	}
	protected function _optimize($params){
		$res	= array();
		foreach($params as $key => $val){
			$new_key	= ":" . $key;
			$res[$new_key]	= $val;
		}
		return $res;
	}
}
