<?php
use Facebook\FacebookAuthorizationException;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookRequestException;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookSession;
use Facebook\GraphObject;

class FacebookApi
{
    const SESSION_KEY = "fb_token";
    protected $app_id;
    protected $secret;
    protected $helper;

    public function __construct($app_id, $secret, $callback_url)
    {
        $this->app_id = $app_id;
        $this->secret = $secret;
        FacebookSession::setDefaultApplication($this->app_id, $this->secret);
        $this->Helper = new FacebookRedirectLoginHelper($callback_url);
    }

    public function getToken()
    {
        return $this->_getTokenSession();
    }

    public function connect()
    {
        $url = $this->Helper->getLoginUrl();
        header("Location: " . $url);
    }

    public function callback()
    {
        try {
            $Session = $this->Helper->getSessionFromRedirect();
        } catch (FacebookRequestException $ex) {
        }
        if (empty($Session)) {
            return false;
        }
        $this->_setTokenSession($Session->getToken());

        return true;
    }

    public function getProfile($token)
    {
        $Session = new FacebookSession($token);
        $Request = new FacebookRequest($Session, "GET", "/me");
        $Response = $Request->execute();
        $GraphObject = $Response->getGraphObject();

        return $GraphObject->asArray();
    }

    protected function _getTokenSession()
    {
        if (empty($_SESSION[self::SESSION_KEY])) {
            return null;
        }

        return $_SESSION[self::SESSION_KEY];
    }

    protected function _setTokenSession($token)
    {
        $_SESSION[self::SESSION_KEY] = $token;
    }
}
