<?php 
namespace App\Core;

class Session {
    private $status;
    private $active;

    public function start() {
        $this->status = session_status();
        if ($this->status == PHP_SESSION_NONE) {
            $this->active = session_start();
        }
    }
    
    public function add($key, $value) {
        $_SESSION[$key] = $value;
    }

    public function get($key) {
        if(isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
        return null;
    }

    public function isActive() {
        return $this->active;
    }

    public function printStatus() {
        switch($this->status) {
            case PHP_SESSION_NONE:
                echo "session none".PHP_EOL;
            break;
            case PHP_SESSION_ACTIVE:
                echo "session active".PHP_EOL;
            break;
            case PHP_SESSION_DISABLED:
                echo "session disabled".PHP_EOL;
            break;
        }
    }

    public function close() {
        session_unset();
        session_destroy();
        $this->active = false;
    }
}