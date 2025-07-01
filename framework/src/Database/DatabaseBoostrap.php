<?php


namespace JosueIsOffline\Framework\Database;

class DatabaseBoostrap
{

  public static function boot(): void
  {
    $config = static::loadConfig();
    $connectionConfig = $config['connections'][$config['default']];

    DB::configure($connectionConfig);
  }


  private static function loadConfig(): array
  {
    $configPath = BASE_PATH . '/config/database.php';

    if (!file_exists($configPath)) {
      throw new DatabaseException("Archivo de configuración de base de datos no encontrado: {$configPath}");
    }

    return require $configPath;
  }
}
