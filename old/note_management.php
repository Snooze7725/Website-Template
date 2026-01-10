<?php
require_once 'JSONHandler.php';
require_once 'server_connect';

function cust_postNotes($mysql) {
    // Checks if it's null, and if it's the right type
    if ($_SERVER["REQUEST_METHOD"] === "POST" 
    and isset($_POST["type"]) 
    and $_POST["type"] === "register_note") {
        // The method without handling the input:
            // $query = "INSERT INTO notes (title, description) VALUES ('$title', '$desc')";
            // $mysql->query($query);
        $title = $_POST['title'] ?? '';
        $desc = $_POST['description'] ?? '';

        $query = $mysql->prepare(
            "INSERT INTO  notes (title, description) VALUES (?, ?)"
        );
        $query->bind_param("ss", $title, $desc);
        $query->execute();
    };
};

function cust_displayNote($mysql) {
    $data = cust_JSONReqHandler("get_notes");
    if ($data) {
        $query = "SELECT id, title, description FROM notes";
        $result = $mysql->query($query);

        $notes = [];
        while ($row = $result->fetch_assoc()) {
            // Appends rows to list
            $notes[] = $row;
        }

        echo json_encode([
            "status" => "success",
            "data" => "notes"
        ]);
    } else {
        return;
    };
};

$mysqli = connectDb();
?>