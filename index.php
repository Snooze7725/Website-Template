<?php
use Core\Router as Router;
use Core\Database as Database;
use Core\Helper as Helper;
use Core\ControllerPath as ControllerPath;
use Core\Logs as Logs;

// Now availabParams in the session global var is available
session_start(); // Gets availabParams from the session


// php -S localhost:8000
require_once __DIR__ . '/database.php';
require_once __DIR__ . '/router.php';
require_once __DIR__ . '/helper.php';
require_once __DIR__ . '/controller_path.php';

$db = new Database();

// Records the HTTP method and URI
$method = $_SERVER['REQUEST_METHOD'] ?? '';
$uri = $_SERVER['REQUEST_URI'] ?? '';

// Logs requests
Logs::httpReqLog("INFO", $method, $uri);

// Gets the controller and method
[$classRef, $classMethod] = Router::routeController($method, $uri);

require_once ControllerPath::filePath($classRef);
$classRefNamespace = ControllerPath::controllerNamespace($classRef);
$class = new $classRefNamespace();

// All available params to outside fns
$availabParams = [
    "uri" => $uri,
    "_GET" => $_GET,
    "_POST" => $_POST,
    "_SESSION" => &$_SESSION, // "&" will force all changes to immediately be copied to the original
    "mysqli" => $db->mysqli,
];

$params = Helper::getFnParams($class, $classMethod, $availabParams);

if (Helper::isStaticMethod($classRefNamespace, $classMethod)) {
    $class::$classMethod(...($params));
} else $class->$classMethod(...($params));
?>