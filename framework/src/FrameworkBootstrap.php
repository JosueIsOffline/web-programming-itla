<?php

namespace JosueIsOffline\Framework;

use JosueIsOffline\Framework\Database\DatabaseBootstrap;
use JosueIsOffline\Framework\Database\Setup\WizardRoutes;

class FrameworkBootstrap
{
  public static function boot(): void
  {
    // Boot the database
    $dbBootstrap = new DatabaseBootstrap();
    $dbBootstrap->boot();
  }

  public static function registerSystemRoutes($routeLoader): void
  {
    // Register wizard routes if database is not configured
    if (self::needsSetup()) {
      $wizardRoutes = WizardRoutes::register();
      foreach ($wizardRoutes as $route) {
        $routeLoader->addRoute($route[0], $route[1], $route[2]);
      }
    }
  }

  public static function needsSetup(): bool
  {
    $dbBootstrap = new DatabaseBootstrap();
    return !$dbBootstrap->configFileExist();
  }

  public static function handleSetupRedirect($request): ?string
  {
    // If setup is needed and user is not on wizard page, redirect
    if (self::needsSetup()) {
      $path = $request->getPathInfo();
      if ($path !== '/framework/database-wizard') {
        return '/framework/database-wizard';
      }
    }
    return null;
  }
}
