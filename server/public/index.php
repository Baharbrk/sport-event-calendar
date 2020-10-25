<?php
header("Access-Control-Allow-Origin: *");

use core\Router;

require dirname(__DIR__) . '/core/Router.php';
require dirname(__DIR__) . '/vendor/autoload.php';

$url    = $_SERVER['REQUEST_URI'];
$router = new Router();
$router->route($url);
