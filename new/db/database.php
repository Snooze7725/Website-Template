<?php
// The function version of it without object orientation is:
// $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
//
// if (mysqli_connect_error()) {
//     die("Database connection failed: " . mysqli_connect_error());
// }
//
// if (!mysqli_set_charset($conn, $charset)) {
//     die("Error setting charset: " . mysqli_error($conn));
// }
class Database {
    public $mysqli;

    public function __construct() {
        $host = 'localhost';
        $db   = 'note_db';
        $user = 'script';
        $pass = 'pass';
        $charset = 'utf8mb4';

        $this->mysqli = new mysqli($host, $user, $pass, $db);

        if ($this->mysqli->connect_errno) {
            die("Database connection failed: " . $this->mysqli->connect_error);
        }
        
        // Determines the char encoding
        if (!$this->mysqli->set_charset($charset)) {
            die("Error setting charset: " . $this->mysqli->error);
        }
    }
}
?>