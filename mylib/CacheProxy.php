<?php
class CacheProxy{
    protected $CacheInst;
    public function __construct($CacheInst){
        $this->CacheInst    = $CacheInst;
    }
    public function fetch($Model, $method, $args=array()){
        $cache_key    = get_class($Model) . "_" . $method;
        foreach($args as $val){
            $cache_key  .= "_" . $val;
        }
        $cache_res  = $this->CacheInst->get($cache_key);
        if($cache_res)  return $cache_res;
        $res    = call_user_func_array(array($Model, $method), $args);
        if($res){
            // 空のときもキャッシュしたほうがいいか悩ましい。。。
            $this->CacheInst->set($cache_key, $res);
        }
        return $res;
    }
}
