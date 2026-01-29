<?php
namespace Core;

final class RequestContext
{
    public readonly string $method;
    public readonly string $uri;

    public function __construct(string $method, string $uri) {
        $this->method = $method;
        $this->uri = $uri;
    }

    public static function fromGlobals(): self {
        return new self(
            $_SERVER['REQUEST_METHOD'] ?? 'CLI',
            parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH)
        );
    }
}
?>