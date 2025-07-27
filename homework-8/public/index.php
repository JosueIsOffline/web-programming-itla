<?php

use JosueIsOffline\Framework\Http\Kernel;
use JosueIsOffline\Framework\Http\Request;
use JosueIsOffline\Framework\View\ViewResolver;
use JosueIsOffline\Framework\Routing\RouteLoader;
use JosueIsOffline\Framework\FrameworkBootstrap;

define('BASE_PATH', dirname(__DIR__));

require_once(BASE_PATH . '/vendor/autoload.php');

FrameworkBootstrap::boot();

$request = Request::create();

$redirectPath = FrameworkBootstrap::handleSetupRedirect($request);
if ($redirectPath) {
  header("Location: $redirectPath");
  exit;
}

$routeLoader = new RouteLoader();

FrameworkBootstrap::registerSystemRoutes($routeLoader);

$kernel = new Kernel($routeLoader);

$viewResolver = new ViewResolver();
$viewResolver->addViewPath(BASE_PATH . '/views');

$response = $kernel->handle($request);
$response->send();
