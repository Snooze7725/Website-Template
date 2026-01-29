<?php
namespace Core;

class Router {
    private static $router = [
        "GET" => [
            "/" => ["GeneralController", "showHomePage", "home.php"],
            "/" => ["GeneralController", "showLoginSignup", "login_&_signup.php"]
        ],
        "POST" => [
            "/action/signup" => ["AuthenticationController", "signupUser", "home.php"]
        ]
    ];

    /**
     * Does a lookup for information regarding the controller and the page related to the request.
     *
     * @param string $uri The URI (Uniform Resource Identifier).
     * @param string $method The method.
     * @return array The controller class, function and page.
     */
    function getController(string $method, string $uri): array {
        if (!isset(self::$router[$method][$uri])) {
            http_response_code(404); 
            echo "404 Not Found"; 
            exit;
        }
        return self::$router[$method][$uri];
    }
}
?>