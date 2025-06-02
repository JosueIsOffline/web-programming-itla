<?php

namespace JosueIsOffline\Framework\Http;

use FastRoute\RouteCollector;
use JosueIsOffline\Framework\Controllers\AbstractController;

use function FastRoute\simpleDispatcher;

class Kernel
{
  public function handle(Request $request): Response
  {
    $dispatcher = simpleDispatcher(function (RouteCollector $routerCollector) {
      $routes = include BASE_PATH . '/routes/web.php';

      foreach ($routes as $route) {
        $routerCollector->addRoute(...$route);
      }
    });

    $routeInfo = $dispatcher->dispatch(
      $request->getMethod(),
      $request->getUri()
    );

    [$status, [$controller, $method], $vars] = $routeInfo;

    $controller = new $controller;

    if ($controller instanceof AbstractController) {
      $controller->setRequest($request);
    }

    return call_user_func_array([$controller, $method], $vars);
  }
}
