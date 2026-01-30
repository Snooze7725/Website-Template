<?php
namespace Core;

class ControllerPath {
    protected static string $controllersDir = __DIR__ . '//controllers/';

    /**
     * Get the full path to a controller file
     *
     * @param string $controllerName Short class name, e.g. "NoteController"
     * @return string Full path to PHP file
     */
    public static function filePath(string $controllerName): string {
        // Convert CamelCase to snake_case filename (optional)
        $fileName = strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $controllerName)) . '.php';
        return realpath(self::$controllersDir. $fileName);
    }

    /**
     * Get the fully-qualified namespace of a controller
     *
     * @param string $controllerName
     * @return string
     */
    public static function controllerNamespace(string $controllerName): string {
        return "Core\Controllers\\" . $controllerName;
    }
}
?>