<?php
// php -S localhost:8000
require_once realpath(__DIR__ . '/db/database.php');
require_once realpath(__DIR__ . '/controllers/note_controller.php');

$mysqli = new Database();
$noteController = new NoteController();

// HANDLING REQUESTS
$method = $_SERVER['REQUEST_METHOD'] ?? '';
$uri = $_SERVER['REQUEST_URI'] ?? '';

// log file for debugging
$reqLog =  "[" . date('Y-m-d H:i:s') . "]" . " INFO: " . $method . " " . $uri . "\n";
file_put_contents(__DIR__ .'/logs/req.log', $reqLog, FILE_APPEND);
switch ($method) {
    case 'POST':
        $type = $_POST['type'] ?? '';
        switch ($uri) {
            case '/form':
                switch ($type) {
                    case 'send_note': 
                        $noteController->storeNote($mysqli->mysqli);
                        break;
                    case 'delete_note':
                        $noteController->deleteNote($mysqli->mysqli, $_POST['id']);
                        break;
                    case 'clear_notes':
                        $noteController->clearNotes($mysqli->mysqli);
                        break;
                    default: 
                        die("Unsupported POST action.");
                };
                break;
            default: 
                die("Unsupported POST URI.");
                
        }
        break;
    case 'GET':
        switch ($uri) {
            case '/':
                $notes = $noteController->showNotes($mysqli->mysqli);
                require_once realpath(__DIR__ . '/views/pages/home.php');
                break;
            case '/send_note':
                $notes = $noteController->showNotes($mysqli->mysqli);
                require_once realpath(__DIR__ . '/views/pages/send_note.php');
                break;
            case '/delete_note':
                $notes = $noteController->showNotes($mysqli->mysqli);
                require_once realpath(__DIR__ . '/views/pages/delete_note.php');
                break;
            default:
                die("Unsupported GET URI.");
        }
        break;
    default:
        die("Unsupported request method.");
}
?>