<?php

namespace JosueIsOffline\Framework\Database;

use JosueIsOffline\Framework\Database\DB;
use JosueIsOffline\Framework\Database\Factories\ConnectionFactory;

class DatabaseBootstrap
{
  public function boot(): void
  {
    if (!$this->configFileExist()) {
      // Don't redirect here - let the framework handle it
      return;
    }
    $config = $this->loadConfig();
    DB::configure($config);
  }

  private function loadConfig(): array
  {
    return json_decode(file_get_contents(__DIR__ . "/../../config/database.json"), true);
  }

  public function configFileExist(): bool
  {
    return file_exists(__DIR__ . '/../../config/database.json');
  }

  private function runInstaller(array $config = []): void
  {
    $newConfig = $this->askForConfig($config);

    if ($this->testConnection($newConfig)) {
      $this->saveConfig($newConfig);
      DB::configure($newConfig);
      $this->createBaseSchema();
    } else {
      die("We couldn't connect to the database");
    }
  }

  private function askForConfig(array $config = []): array
  {
    return [
      'driver' => $config['driver'],
      'host' => $config['host'],
      'port' => $config['port'] ?? 3306,
      'database' => $config['database'],
      'username' => $config['username'],
      'password' => $config['password'],
      'charset' => 'utf8mb4',
      'collation' => 'utf8mb4-unicode_ci'
    ];
  }

  private function testConnection(array $config = []): bool
  {
    try {
      $factory = new ConnectionFactory();
      $connection = $factory->create($config);
      $connection->query('SELECT 1');

      return true;
    } catch (\Throwable $e) {
      return false;
    }
  }

  public function saveConfig(array $config): void
  {
    // Ensure config directory exists
    $configDir = __DIR__ . '/../../config';
    $configFile = $configDir . '/database.json';

    error_log("Attempting to save config to: " . $configFile);
    error_log("Config data: " . print_r($config, true));

    if (!is_dir($configDir)) {
      error_log("Creating directory: " . $configDir);
      if (!mkdir($configDir, 0755, true)) {
        throw new \Exception("Could not create config directory: " . $configDir);
      }
    }

    // Check if directory is writable
    if (!is_writable($configDir)) {
      throw new \Exception("Config directory is not writable: " . $configDir);
    }

    $jsonContent = json_encode($config, JSON_PRETTY_PRINT);

    if ($jsonContent === false) {
      throw new \Exception("Could not encode config to JSON: " . json_last_error_msg());
    }

    error_log("JSON content: " . $jsonContent);

    $result = file_put_contents($configFile, $jsonContent);

    if ($result === false) {
      throw new \Exception("Could not write config file: " . $configFile);
    }

    error_log("Config file written successfully. Bytes written: " . $result);

    // Verify the file was created
    if (!file_exists($configFile)) {
      throw new \Exception("Config file was not created: " . $configFile);
    }

    error_log("Config file verified to exist: " . $configFile);
  }

  public function createBaseSchema(): void
  {
    $conn = DB::connection();
    $sql = "CREATE TABLE IF NOT EXISTS personajes (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nombre VARCHAR(100) NOT NULL,
            profesion VARCHAR(100),
            creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";

    $conn->execute($sql);
  }
}
