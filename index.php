<?php

require_once (__DIR__ . '/Route.php');

$route_name = $_SERVER['REQUEST_URI'];

$http_method = $_SERVER["REQUEST_METHOD"];
$params = $http_method !== 'GET' ? $_POST : $_GET;
Route::go($route_name, $params);
