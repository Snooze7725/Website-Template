<?php
namespace Core;

class Helper {
    /**
     * Gets the params of a Fn - this is just for dynamic operations
     *
     * @param object $class The object used to get the Fn.
     * @param string $Fn The Fn that is getting introspected.
     * @param array $data The available params.
     * @return array The params of the Fn.
     */
    public static function getFnParams(object $class, string $Fn, array $data): array {
        $reflect = new \ReflectionMethod($class, $Fn);
        $params = [];
        foreach ($reflect->getParameters() as $param) {
            $name = $param->getName();
            if (isset($data[$name])) array_push($params, $data[$name]);
        }

        return $params;
    }

    /**
     * Checks if the method is static or dynamic
     *
     * @param string $methodName The method name.
     * @param string $className The class name.
     * @return bool If the method is static.
     */
    public static function isStaticMethod(string $className, string $methodName): bool {
        $reflection = new \ReflectionMethod($className, $methodName);
        return $reflection->isStatic();
    }                                       


    /**
     * Just grabs data to show the home page.
     *
     * @param \mysqli $mysqli The mysqli connection obj.
     * @param string $page The page chosen for the controller.
     */
    public static function showPage(string $uri): void {
        $page = match ($uri) {
            "/delete_note" => 'delete_note.php',
            "/send_note" => 'send_note.php',
            default => 'home.php',
        };

        require_once realpath(__DIR__ . '/../views/pages/' . $page);
    }
}