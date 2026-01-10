<?php
function cust_servConnect() {
    $db_host = "localhost";
    $db_user = "script";
    $db_pass = "pass";
    $db_name = "note_db";
    $mysql = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($mysql->connect_error) {
        die("Connection failed: " . $mysql->connect_error);
    };

    return $mysql;
};
?>