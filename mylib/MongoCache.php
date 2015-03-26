<?php
class MongoCache{
    protected $Client;
    protected $Db;
    protected $Collection;
    protected $index_key = 'cache_key';
    protected $expire = 10;  // 86400 = 1day cache
    public function __construct($db_name='mongocache', $collection_name='cache'){
        $this->Client   = new MongoClient();
        $this->Db   = $this->Client->selectDb($db_name);
        $this->Collection   = $this->Db->selectCollection($collection_name);
        // すでにindex張ってあったら無視するようにしたいなぁ
        $this->_createIndex();
    }
    public function get($key){
       $res = $this->Collection->findOne(array($this->index_key => $key));
        if(!$res)   return array();
        if($this->_isExpire($res))  return array();
        return $res['content'];
    }
    public function set($key, $content, $is_json=false){
        if($is_json)    $content    = json_decode($content, true);
        $doc = $this->Collection->findOne(array($this->index_key => $key));
        if($doc){
            $this->Collection->update(
                array($this->index_key => $key),
                array($this->index_key => $key, 'content' => $content, 'created' => time())
            );
            return ;
        }
        $this->Collection->insert(array(
            $this->index_key => $key,
            'content'   => $content,
            'created'   => time()
        ));
    }
    protected function _isExpire($res){
        if(empty($res['created']))  return true;
        $now    = time();
        $diff   = $now - $res['created'];
        return ($diff > $this->expire) ? true : false;
    }
    protected function _createIndex(){
        $this->Collection->createIndex(
            array($this->index_key => MongoCollection::ASCENDING),
            array('unique' => true)
        );
    }
}
