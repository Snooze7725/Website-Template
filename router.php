<?php
namespace Core;

class Router {
    private static $staticRouter = [
        "GET" => [
            "home" => ["/" => ["Helper", "showPage"]],
            "note" => [
                "/delete_note" => ["Helper", "showPage"],
                "/send_note" => ["Helper", "showPage"]
            ],
            "userAuth" => ["/login-signup" => ["GeneralController", "showLoginSignup"]]
        ],
        "POST" => [
            "notes" => [
                "/note/send" => ["NoteController", "addNote"],
                "/note/delete" => ["NoteController", "deleteNote"]
            ],
            "userAuth" => [
                "/user/signup" => ["AuthenticationController", "signupUser"],
                "/user/login" => ["AuthenticationController", "loginUser"]
            ]
        ]
    ];

    /**
     * Does a lookup for information regarding the controller and the page related to the request.
     *
     * @param string $uri The URI (Uniform Resource Identifier).
     * @param string $method The method.
     * @return array The controller class, function and page.
     */
    public static function routeController(string $method, string $uri): array {
            // Loop through each group
        foreach (self::$staticRouter[$method] as $routeGroup => $routes) {
            // $routes is the nested array for the group
            if (isset($routes[$uri])) {
                return $routes[$uri]; // found the handler
            }
        }

        // No match
        http_response_code(404);
        echo "404 Not Found (routeController): " . $method . " " . $uri; // DANGEROUS
        exit;
    }
}
?>