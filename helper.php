<?php
namespace Core;

class Helper {
    /**
     * Gets the params of a Fn - this is just for dynamic operations
     *
     * @param object $class The object used to get the Fn.
     * @param string $Fn The Fn that is getting introspected.
     * @param array $availabParams The available params.
     * @return array The params of the Fn.
     */
    public static function getFnParams(object $class, string $classMethod, array $availabParams): array {
        $reflect = new \ReflectionMethod($class, $classMethod);
        $params = [];
        foreach ($reflect->getParameters() as $param) {
            $name = $param->getName();
            if (isset($availabParams[$name])) array_push($params, $availabParams[$name]);
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
    public static function isStaticMethod(string $classRefNamespace, string $classMethod): bool {
        $reflection = new \ReflectionMethod($classRefNamespace, $classMethod);
        return $reflection->isStatic();
    }
}