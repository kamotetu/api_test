<?php

class Route
{
    private const Routes = [
        '/' => '/view/index.php',
        '/index' => '/view/index.php',
        '/post' => '/api/post.php'
    ];

    public static $root = __DIR__;

    public static $params;

    public static $parent_layout_path = __DIR__ . '/view/layout.php';

    public static function go($route_name, array $params)
    {
        self::$params = $params;

        $route_value = self::getRouteValueByName($route_name);
        if (preg_match('/\A\/view\/.+\z/', $route_value)) {
            return include(self::$parent_layout_path);
        }

        return include(self::getFilePathByName($route_name));
    }

    public static function getFilePathByName(string $route_name): string
    {
        return self::$root . self::Routes[$route_name];
    }

    public static function createRouteUrl(string $route_name): string
    {
        return $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $route_name;
    }

    public static function getRouteValueByName(string $route_name): string
    {
        return self::Routes[$route_name];
    }
}
