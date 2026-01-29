<?php
namespace Core\Controllers;

use Core\Helper as Helper;

require_once realpath(__DIR__ . '/../helper.php');

class ControllerHelper {           
    /**
     * Just grabs data to show the home page.but 
     *
     * @param \mysqli $mysqli The mysqli connection obj.
     * @param string $page The page chosen for the controller.
     */
    public static function showPage(\mysqli $mysqli, string $uri): void {
        $routes = [
            "/" => [
                'view' => __DIR__ . '/../views/pages/home.php',
                'data' => function(\mysqli $mysqli) {
                    require_once __DIR__ . '/note.php';
                    $ctrl = new NoteController();

                    $classRef = "NoteController";
                    $classMethod = "getNotes";

                    if (Helper::isStaticMethod($classRef, $classMethod)) {
                        $notes = $classRef::$classMethod($mysqli);
                    } else $notes = $ctrl->$classMethod($mysqli);
                }
            ],
            "/send_note" => [
                'view' => __DIR__ . '/../views/pages/send_note.php',
                'data' => function(\mysqli $mysqli) {
                    require_once __DIR__ . '/note.php';
                    $ctrl = new NoteController();

                    $classRef = "NoteController";
                    $classMethod = "getNotes";

                    if (Helper::isStaticMethod($classRef, $classMethod)) {
                        $notes = $classRef::$classMethod($mysqli);
                    } else $notes = $ctrl->$classMethod($mysqli);
                }
            ],
            "/delete_note" => [
                'view' => __DIR__ . '/../views/pages/delete_note.php',
                'data' => function(\mysqli $mysqli) {
                    require_once __DIR__ . '/note.php';
                    $ctrl = new NoteController();

                    $classRef = "NoteController";
                    $classMethod = "getNotes";

                    if (Helper::isStaticMethod($classRef, $classMethod)) {
                        $notes = $classRef::$classMethod($mysqli);
                    } else $notes = $ctrl->$classMethod($mysqli);
                }
            ],
            "/login-signup" => [
                'view' => __DIR__ . '/../views/pages/login_signup.php',
                'data' => []
            ],
        ];

        if (!isset($routes[$uri])) {
            http_response_code(404);
            echo "404 Not Found (showPage): GEt " . $uri; // DANGEROUS
            exit;
        }

        $route = $routes[$uri];

        // Execute data callback to get page-specific variables
        $data = $route['data']($mysqli);

        // Extract variables into local scope for the view
        extract($data);

        require_once realpath($route['view']);
    }
}
?>