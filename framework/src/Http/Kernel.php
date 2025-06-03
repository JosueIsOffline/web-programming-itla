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

    $status = $routeInfo[0];

    if ($status === \FastRoute\Dispatcher::FOUND) {
      [, [$controller, $method], $vars] = $routeInfo;

      $controller = new $controller;

      if ($controller instanceof AbstractController) {
        $controller->setRequest($request);
      }

      return call_user_func_array([$controller, $method], $vars);
    } elseif ($status === \FastRoute\Dispatcher::NOT_FOUND) {

      return new Response('404 Not Found', 404);
    } elseif ($status === \FastRoute\Dispatcher::METHOD_NOT_ALLOWED) {
      // Optional: get allowed methods for this route
      $allowedMethods = $routeInfo[1];
      return new Response('405 Method Not Allowed', 405);
    }

    return new Response('500 Internal Server Error', 500);
  }
}
