<?php

// Using PDO
class database
{

    // 環境の切替はenviroment.phpから行ってください
    protected $config = [
        'production' => [
            'type' => '',
            'dbname' => '',
            'host' => '',
            'user' => '',
            'password' => '',
            'table_prefix' => '',
            'encoding' => 'utf8',
        ],
        'staging' => [
            'type' => '',
            'dbname' => '',
            'host' => '',
            'user' => '',
            'password' => '',
            'table_prefix' => '',
            'encoding' => 'utf8',
        ],
        'development' => [
            'type' => 'mysql',
            'dbname' => 'tackphp',
            'host' => 'localhost',
            'user' => 'root',
            'password' => 'vagrant',
            'table_prefix' => 'tackphp_',
            'encoding' => 'utf8',
        ],
        'test' => [
            'type' => '',
            'dbname' => '',
            'host' => '',
            'user' => '',
            'password' => '',
            'table_prefix' => '',
            'encoding' => 'utf8',
        ],
    ];

    public static $_instance = array();
    public $is_connect = false;
    protected $info;
    protected $dbh;
    protected $stmt;

    public function __construct($config_key)
    {
        if (empty($this->config[$config_key])) {
            return false;
        }
        $config = $this->config[$config_key];
        try {
            $dsn = $config['type'] . ":host=" . $config['host'] . ";dbname=" . $config['dbname'];
            $dbh = new PDO($dsn, $config['user'], $config['password']);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $res = $dbh->exec("SET NAMES " . $config['encoding']);
            $this->dbh = $dbh;
            $this->info = $config;
            $this->is_connect = true;
        } catch (PDOException $e) {
            $this->is_connect = false;
        }
    }

    public static function getInstance($id)
    {
        if (empty(self::$_instance[$id])) {
            self::$_instance[$id] = new database($id);
        }

        return self::$_instance[$id];
    }

    public function execQuery($sql, $params = array())
    {
        if (!$this->dbh) {
            throw new Exception("CAN'T CONNECT DATABASE");
        }
        $params = $this->_optimize($params);
        try {
            SqlLog::set($sql, $params);
            $stmt = $this->dbh->prepare($sql);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $this->_bind($stmt, $params);
            $res = $stmt->execute();
        } catch (PDOException $e) {
            $message = DEBUG_MODE ? $e->getMessage() : "SYSTEM ERROR";
            throw new Exception($message);
        }
        $this->stmt = $stmt;

        return $res;
    }

    public function fetchAll()
    {
        $list = $this->stmt->fetchAll();

        return $list ? $list : array();
    }

    public function fetch()
    {
        $data = $this->stmt->fetch();

        return $data ? $data : array();
    }

    public function getLastInsertId()
    {
        return $this->dbh->lastInsertId();
    }

    public function beginTransaction()
    {
        return $this->dbh->beginTransaction();
    }

    public function commit()
    {
        return $this->dbh->commit();
    }

    public function rollback()
    {
        return $this->dbh->rollback();
    }

    public function getColumnList($table_name)
    {
        if (!$this->dbh) {
            return array();
        }
        $result = array();
        $stmt = $this->dbh->query("SELECT * FROM " . $table_name . " LIMIT 0");
        for ($i = 0; $i < $stmt->columnCount(); $i++) {
            $meta = $stmt->getColumnMeta($i);
            $result[] = $meta['name'];
        }

        return $result;
    }

    public function getInfo()
    {
        return $this->info;
    }

    protected function _bind($stmt, $params)
    {
        foreach ($params as $key => $val) {
            $type = PDO::PARAM_STR;
            if (is_numeric($val)) {
                $type = PDO::PARAM_INT;
            }
            $stmt->bindValue($key, $val, $type);
        }
    }

    protected function _optimize($params)
    {
        $res = array();
        foreach ($params as $key => $val) {
            $new_key = ":" . $key;
            $res[$new_key] = $val;
        }

        return $res;
    }
}
