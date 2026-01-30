<?php
namespace Core\Controllers;

use Core\ControllerPath as ControllerPath;
use Core\Controllers\BaseController as BaseController;

require_once realpath(__DIR__ . "/../controller_path.php");
require_once ControllerPath::filePath("BaseController");

class NoteController extends BaseController {
    // function static function identify(): string {
    //     return 
    // }

    public static function addNote(\mysqli $mysqli, string $uri): void {
        // "trim()" - removes leading and trailing whitespace
        $title = trim($_POST['title'] ?? '');
        $content = trim($_POST['content'] ?? '');
        $date = date('Y-m-d H:i:s'); 

        $stmt = $mysqli->prepare("INSERT INTO notes (title, content, publish_date) VALUES (?, ?, ?)");
        if (!$stmt) {
            return;
        }
        $stmt->bind_param("sss", $title, $content, $date);
        $stmt->execute();
        $stmt->close();

        $uriNarrow = [];
        $keys = [["/user/signup", "/user/login"], ["/note/send"], ["/note/delete"]];
        $values = ["/", "/send_note", "delete_note"];
        for ($i = 0; $i < count($values); $i++) {
            $uriNarrow[$keys[$i]] = $values[$i];
        }
        
        var_dump($uriNarrow);
        exit();

        self::showPage($mysqli, $uri);
    }

    /**
     * Adds two numbers together.
     *
     * @param mysqli $mysqli The mysqli connection obj.
     * @return array $notes A bunch of notes from the database.
     */
    public static function getNotes(\mysqli $mysqli): array {
        // Fetch all notes first
        $notes = [];
        // "DESC" - makes the order reversed
        $stmt = $mysqli->query("SELECT ID, title, content, publish_date FROM notes ORDER BY ID");
        if (!$stmt) {
            die("Query failed: " . $mysqli->error);
        }

        while ($note = $stmt->fetch_assoc()) {
            $notes[] = [
                // "(int)" - is a cast operator that sets the typing of the content
                // entering the array
                'ID' => $note['ID'],
                'title' => htmlspecialchars($note['title'], ENT_QUOTES, 'UTF-8'),
                'content' => htmlspecialchars($note['content'], ENT_QUOTES, 'UTF-8'),
                'publish_date' => $note['publish_date']
            ];
        }

        if (!$notes) {
            return [];
        }

        return $notes;
    }

    public static function deleteNote(\mysqli $mysqli, int $id): void {
        $stmt = $mysqli->prepare("DELETE FROM notes WHERE ID = ?");
        if (!$stmt) {
            die("Query failed: " . $mysqli->error);
        }

        $stmt->bind_param("i", $id);
        if (!$stmt->execute()) {
            die("Execute failed: " . $stmt->error);
        }
    }

    public static function clearNotes(\mysqli $mysqli): void {
        $stmt = $mysqli->prepare("DELETE FROM notes");
        if (!$stmt) {
            die("Query failed: " . $mysqli->error);
        }

        if (!$stmt->execute()) {
            die("Execute failed: " . $stmt->error);
        }
    }
}
?>