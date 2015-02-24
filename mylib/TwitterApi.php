<?php
use Abraham\TwitterOAuth\TwitterOAuth;
class TwitterApi{
        const SESSION_KEY = "tw_token";
        public function __construct($consumer_key, $consumer_secret){
                $this->consumer_key     = $consumer_key;
                $this->consumer_secret = $consumer_secret;
        }
        public function connect($callback_url){
                $connection     = new TwitterOAuth($this->consumer_key, $this->consumer_secret);
                $p      = array('oauth_callback' => $callback_url);
                $request_token  = $connection->oauth("oauth/request_token", $p);
                $this->_setRequestTokenSession($request_token);
                $p      = array('oauth_token' => $request_token['oauth_token']);
                $url    = $connection->url("oauth/authorize", $p);
                header("Location: " . $url);
                exit;
        }
        public function callback(){
                $request_token  = $this->_getRequestTokenSession();
                if(!$request_token)     return false;
                if(empty($_REQUEST['oauth_token']))     return false;
                if(empty($_REQUEST['oauth_verifier']))  return false;
                if($_REQUEST['oauth_token'] != $request_token['oauth_token']) return false;
                $connection = new TwitterOAuth($this->consumer_key, $this->consumer_secret, $request_token['oauth_token'], $request_token['oauth_token_secret']);
                $p      = array('oauth_verifier' => $_REQUEST['oauth_verifier']);
                $access_token = $connection->oauth("oauth/access_token", $p);
                if(!$access_token)      return false;
                $this->_setAccessTokenSession($access_token);
                return true;
        }
        public function getToken(){
                return $this->_getAccessTokenSession();
        }
        public function getProfile($token, $secret){
                $connection     = new TwitterOAuth($this->consumer_key, $this->consumer_secret, $token, $secret);
                $user = $connection->get("account/verify_credentials");
                if(!$user)      return array();
                return (array)$user;
        }
        public function getConnection($token, $secret){
                $connection     = new TwitterOAuth($this->consumer_key, $this->consumer_secret, $token, $secret);
                return $connection;
        }
        protected function _getAccessTokenSession(){
                if(empty($_SESSION[self::SESSION_KEY]['access_token'])) return array();
                return $_SESSION[self::SESSION_KEY]['access_token'];
        }
        protected function _setAccessTokenSession($access_token){
                $_SESSION[self::SESSION_KEY]['access_token']    = $access_token;
        }
        protected function _getRequestTokenSession(){
                if(empty($_SESSION[self::SESSION_KEY]['request_token']))        return array();
                return $_SESSION[self::SESSION_KEY]['request_token'];
        }
        protected function _setRequestTokenSession($request_token){
                $_SESSION[self::SESSION_KEY]['request_token']   = $request_token;
        }
}
