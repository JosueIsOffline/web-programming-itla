<?php

namespace JosueIsOffline\Framework\Database\Setup;


class WizardRoutes
{
  public static function register(): array
  {
    return [
      ['GET', '/framework/database-wizard', [DatabaseWizardController::class, 'index']],
      ['POST', '/framework/database-wizard', [DatabaseWizardController::class, 'index']],
    ];
  }

  public static function shouldRegister(): bool
  {
    // Only register wizard routes if no database config exists
    $bootstrap = new \JosueIsOffline\Framework\Database\DatabaseBootstrap();
    return !$bootstrap->configFileExist();
  }
}
