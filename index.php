<?php
use Core\Router as Router;
use Core\Database as Database;
use Core\Helper as Helper;

// Now data in the session global var is available
session_start(); // Gets data from the session


// php -S localhost:8000
require_once __DIR__ . '/database.php';
require_once __DIR__ . '/router.php';
require_once __DIR__ . '/helper.php';

$db = new Database();

// Records the HTTP method and URI
$method = $_SERVER['REQUEST_METHOD'] ?? '';
$uri = $_SERVER['REQUEST_URI'] ?? '';

// Logs requests
$reqLog =  "[" . date('Y-m-d H:i:s') . "]" . " INFO: " . $method . " " . $uri . "\n";
file_put_contents(__DIR__ .'/logs/req.log', $reqLog, FILE_APPEND);

// Gets the controller and method
[$classRef, $classMethod] = Router::routeController($method, $uri);

$classPaths = [
    "Helper" => __DIR__ . "/controllers/controller_helper.php",
    "NoteController" => __DIR__ . "/controllers/note.php",
];
require_once $classPaths[$classRef];
$classRef = "Core\\Controllers\\" . $classRef; // Add the namespace
$class = new $classRef();

// All available params to outside fns
$data = [
    "uri" => $uri,
    "_GET" => $_GET,
    "_POST" => $_POST,
    "_SESSION" => &$_SESSION, // "&" will force all changes to immediately be copied to the original
    "mysqli" => $db->mysqli,
];

$params = Helper::getFnParams($class, $classMethod, $data);

if (Helper::isStaticMethod($classRef, $classMethod)) {
    $class::$classMethod(...($params));
} else $class->$classMethod(...($params));
?>