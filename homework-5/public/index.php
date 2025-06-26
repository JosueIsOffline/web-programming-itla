<?php

use JosueIsOffline\Framework\Http\Kernel;
use JosueIsOffline\Framework\Http\Request;
use JosueIsOffline\Framework\View\ViewResolver;
use JosueIsOffline\Framework\Routing\RouteLoader;

define('BASE_PATH', dirname(__DIR__));

require_once(BASE_PATH . '/vendor/autoload.php');

$dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH);
$dotenv->load();

$request = Request::create();
$routeLoader = new RouteLoader();
$kernel = new Kernel($routeLoader);

$viewResolver = new ViewResolver();
$viewResolver->addViewPath(BASE_PATH, '/views');

$response = $kernel->handle($request);
$response->send();
