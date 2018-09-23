<?php

class Session {
    protected static $sessionStarted = false;
    protected static $sessionIdRegenerated = false;

    public function __construct() {
        if(!self::$sessionStarted) {
            session_start();

            self::$sessionStarted = true;
        }
    }

    public function set($name, $value) {
        $_SESSION[$name] = $value;
    }

    public function get($name, $defaurt = null) {
        if(isset($_SESSION[$name])) {
            return $_SESSION[$name];
        }
        return $defaurt;
    }

    public function remove($name) {
        unset($_SESSION[$name]);
    }

    public function clear() {
        $_SESSION = array();
    }

    public function regenerate($destroy = true) {
        if(!self::$sessionIdRegenerated) {
            session_regenarate_id($destroy);

            self::$sessionIdREgenerated = true;
        }
    }

    public function setAuthenticated($bool) {
        $this->set('_authenticated', (bool)$bool);

        $this->regenerate();
    }

    public function isAuthenticated() {
        return $this->get('_authenticated', false);
    }
}
