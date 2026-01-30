<?php
namespace Core\Controllers;

use Core\Helper as Helper;
use Core\ControllerPath as ControllerPath;

require_once realpath(__DIR__ . '/../helper.php');

class BaseController {           
    /**
     * Just grabs data to show the home page.but 
     *
     * @param \mysqli $mysqli The mysqli connection obj.
     * @param string $page The page chosen for the controller.
     */
    public static function showPage(\mysqli $mysqli, string $uri): void {
        $pageGroups = [
            "/" => [
                'view' => __DIR__ . '/../views/pages/home.php',
                'data' => function(\mysqli $mysqli) {
                    require_once ControllerPath::filePath("NoteController");

                    $classRef = ControllerPath::controllerNamespace("NoteController");
                    $obj = new $classRef();
                    $classMethod = "getNotes";

                    if (Helper::isStaticMethod($classRef, $classMethod)) {
                        return $notes = $classRef::$classMethod($mysqli);
                    } else return $notes = $obj->$classMethod($mysqli);
                }
            ],
            "/send_note" => [
                'view' => __DIR__ . '/../views/pages/send_note.php',
                'data' => function(\mysqli $mysqli) {
                    require_once ControllerPath::filePath("NoteController");

                    $classRef = ControllerPath::controllerNamespace("NoteController");
                    $obj = new $classRef();
                    $classMethod = "getNotes";

                    if (Helper::isStaticMethod($classRef, $classMethod)) {
                        return $notes = $classRef::$classMethod($mysqli);
                    } else return $notes = $obj->$classMethod($mysqli);
                }
            ],
            "/delete_note" => [
                'view' => __DIR__ . '/../views/pages/delete_note.php',
                'data' => function(\mysqli $mysqli) {
                    require_once ControllerPath::filePath("NoteController");

                    $classRef = ControllerPath::controllerNamespace("NoteController");
                    $obj = new $classRef();
                    $classMethod = "getNotes";

                    if (Helper::isStaticMethod($classRef, $classMethod)) {
                        return $notes = $classRef::$classMethod($mysqli);
                    } else return $notes = $obj->$classMethod($mysqli);
                }
            ],
            "/login-signup" => [
                'view' => __DIR__ . '/../views/pages/login_signup.php',
                'data' => []
            ],
        ];
        
        if (isset($pageGroups[$uri])) {
            $chosenRoute = $pageGroups[$uri];
        } else {
            // DEB-LOG
            http_response_code(404);
            $desc = "Uri couldn't be found";
            Logs::debugLog("ERROR", __CLASS__, __FUNCTION__, $method, $uri, $desc, []);
            exit;
        }

        // Execute data callback to get page-specific variables
        if ($chosenRoute['data']) $data = $chosenRoute['data']($mysqli, $method, $uri, $session);

        require_once realpath($chosenRoute['view']);
    }
}
?>