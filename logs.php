<?php
namespace Core;

class Logs {
    public static function httpReqLog(string $type, string $method, string $uri): void {
        $utcDate =  "[" . date('Y-m-d H:i:s') . "]";
        $type = "[" . $type . "]";
        $output =  $utcDate . $type . " " . $method . " " . $uri . "\n";
        file_put_contents(__DIR__ .'/logs/req.log', $output, FILE_APPEND);
    }

    /**
     * Logs a debug message to a file in the format:
     * [UTC][TYPE][CLASS][FUNCTION] METHOD URI | DESC | KEY=VALUE
     *
     * @param string $type   The type of log (e.g., INFO, ERROR).
     * @param string $class  The class name where the log is called.
     * @param string $fn     The function name where the log is called.
     * @param string $method The HTTP method (GET, POST, etc.).
     * @param string $uri    The URI or endpoint being accessed.
     * @param string $desc   Description of the log entry.
     * @param array<string, mixed> $data Optional key-value data to include in the log.
     *
     * @return void
     */
    public static function debugLog(
        string $type,
        string $class,
        string $fn,
        string $method,
        string $uri,
        string $desc,
        array $data = []
    ): void {
        $utcDate = "[" . date('Y-m-d H:i:s') . "]";
        $type = "[" . $type . "]";

        $class = $class ? "[$class]" : "[NONE]";
        $fn = $fn ? "[$fn]" : "[NONE]";

        $method = $method ? $method : "";
        $uri = $uri ? $uri : "";
        $httpReq = $method . " " . $uri;

        $desc = $desc ?: "NONE";

        $newData = $data
            // implode gets array items and joins them, and array map applies a fn to an array
            ? implode(" ", array_map(fn($k, $v) => "$k=$v", array_keys($data), $data))
            : "NONE";

        $output = $utcDate . $type . $class . $fn . " " . $httpReq . " | " . $desc . " | " . $newData . "\n";
        file_put_contents(__DIR__ . '/logs/debug.log', $output, FILE_APPEND);
    }
}
?>