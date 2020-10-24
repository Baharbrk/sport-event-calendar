<?php

use server\core\Router;


$url    = $_SERVER['REQUEST_URI'];
$router = new Router();
$router->route($url);
