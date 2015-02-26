<?php

class SimpleLogger
{
    protected static $instance_list = array();
    protected $log_path;

    public function __construct($file_name)
    {
        $this->log_path = LOG_DIR . $file_name;
    }

    public static function getInstance($file_name)
    {
        if (!empty(self::$instance_list[$file_name])) {
            return self::$instance_list[$file_name];
        }
        self::$instance_list[$file_name] = new self($file_name);

        return self::$instance_list[$file_name];
    }

    public function info($message)
    {
        return $this->_write("info", $message);
    }

    public function error($message)
    {
        return $this->_write("error", $message);
    }

    protected function _write($type, $message)
    {
        if (!is_writable(LOG_DIR)) {
            return false;
        }
        $str = "[" . $type . "][" . date("Y-m-d H:i:s") . "]" . $message . "\n";
        error_log($str, 3, $this->log_path);

        return true;
    }
}
