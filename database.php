<?php
namespace Core;

class Database {
    public $mysqli;

    public function __construct() {
        $host = 'localhost';
        $db   = 'note_db';
        $user = 'script';
        $pass = 'pass';

        $this->mysqli = new \mysqli($host, $user, $pass, $db);

        if ($this->mysqli->connect_errno) {
            die("Database connection failed: " . $this->mysqli->connect_error);
        }
        
        // Determines the char encoding
        if (!$this->mysqli->set_charset('utf8mb4')) {
            die("Error setting charset: " . $this->mysqli->error);
        }
    }
}
?>