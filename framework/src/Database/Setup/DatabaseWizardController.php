<?php

namespace JosueIsOffline\Framework\Database\Setup;

use JosueIsOffline\Framework\Http\Response;
use JosueIsOffline\Framework\Http\Request;
use JosueIsOffline\Framework\Database\DatabaseBootstrap;
use JosueIsOffline\Framework\Database\Factories\ConnectionFactory;
use JosueIsOffline\Framework\Controllers\AbstractController;

class DatabaseWizardController extends AbstractController
{
  private DatabaseBootstrap $bootstrap;

  public function __construct()
  {
    $this->bootstrap = new DatabaseBootstrap();
  }

  public function index(): Response
  {
    // Check if we already have a config file
    if ($this->bootstrap->configFileExist()) {
      // Redirect to app if already configured
      return new Response('', 302, ['Location' => '/']);
    }

    $method = $this->request->getMethod();

    if ($method === 'GET') {
      return $this->render('framework/database-wizard.html.twig', [
        'step' => 1,
        'config' => [],
        'tables' => [],
        'error' => '',
        'success' => ''
      ]);
    }

    // Handle POST request
    $params = $this->request->getAllPost();
    $step = (int) ($params['step'] ?? 1);

    switch ($step) {
      case 2:
        return $this->handleConnectionTest($params);
      case 3:
        return $this->handleDatabaseCreation($params);
      case 4:
        return $this->handleTableConfiguration($params);
      case 5:
        return $this->handleCreateTables($params);
      case 6:
        return $this->handleFinalSave($params);
      default:
        return $this->render('framework/database-wizard.html.twig', [
          'step' => 1,
          'config' => [],
          'tables' => [],
          'error' => '',
          'success' => ''
        ]);
    }
  }

  private function handleConnectionTest($params): Response
  {
    $config = $this->buildConfig($params);

    // Validate required fields
    $validation = $this->validateConfig($config);
    if (!$validation['valid']) {
      return $this->render('framework/database-wizard.html.twig', [
        'step' => 1,
        'config' => $config,
        'tables' => [],
        'error' => $validation['error'],
        'success' => ''
      ]);
    }

    // Test connection
    try {
      if ($config['driver'] === 'sqlite') {
        $factory = new ConnectionFactory();
        $connection = $factory->create($config);
        $connection->query('SELECT 1');
      } else {
        $testConfig = $config;
        unset($testConfig['database']);

        $factory = new ConnectionFactory();
        $connection = $factory->create($testConfig);
        $connection->query('SELECT 1');
      }

      return $this->render('framework/database-wizard.html.twig', [
        'step' => 2,
        'config' => $config,
        'tables' => [],
        'error' => '',
        'success' => 'Conexión al servidor establecida correctamente'
      ]);
    } catch (\Exception $e) {
      return $this->render('framework/database-wizard.html.twig', [
        'step' => 1,
        'config' => $config,
        'tables' => [],
        'error' => 'Error de conexión: ' . $e->getMessage(),
        'success' => ''
      ]);
    }
  }

  private function handleDatabaseCreation($params): Response
  {
    $config = $this->buildConfig($params);

    try {
      // Create database if it doesn't exist (for server-based databases)
      if ($config['driver'] !== 'sqlite') {
        $this->createDatabase($config);
      }

      // Test connection with the database
      $factory = new ConnectionFactory();
      $connection = $factory->create($config);
      $connection->query('SELECT 1');

      return $this->render('framework/database-wizard.html.twig', [
        'step' => 3,
        'config' => $config,
        'tables' => [],
        'error' => '',
        'success' => 'Base de datos creada exitosamente. Ahora configuremos las tablas.'
      ]);
    } catch (\Exception $e) {
      return $this->render('framework/database-wizard.html.twig', [
        'step' => 2,
        'config' => $config,
        'tables' => [],
        'error' => 'Error al crear la base de datos: ' . $e->getMessage(),
        'success' => ''
      ]);
    }
  }

  private function handleTableConfiguration($params): Response
  {
    $config = $this->buildConfig($params);

    // If we're coming from step 3, show the table configuration form
    if (!isset($params['table_names']) || empty($params['table_names'])) {
      return $this->render('framework/database-wizard.html.twig', [
        'step' => 4,
        'config' => $config,
        'tables' => [],
        'error' => '',
        'success' => ''
      ]);
    }

    // Process table configuration and show step 5
    $tables = $this->buildTablesConfig($params);
    $config['tables'] = $tables;

    return $this->render('framework/database-wizard.html.twig', [
      'step' => 5,
      'config' => $config,
      'tables' => $tables,
      'error' => '',
      'success' => 'Configuración de tablas procesada correctamente'
    ]);
  }

  private function handleCreateTables($params): Response
  {
    $config = $this->buildConfig($params);
    $tables = $this->buildTablesConfig($params);

    try {
      $factory = new ConnectionFactory();
      $connection = $factory->create($config);

      foreach ($tables as $table) {
        $this->createCustomTable($connection, $table, $config['driver']);
      }

      return $this->render('framework/database-wizard.html.twig', [
        'step' => 5,
        'config' => $config,
        'tables' => $tables,
        'error' => '',
        'success' => 'Todas las tablas han sido creadas exitosamente'
      ]);
    } catch (\Exception $e) {
      return $this->render('framework/database-wizard.html.twig', [
        'step' => 4,
        'config' => $config,
        'tables' => [],
        'error' => 'Error al crear las tablas: ' . $e->getMessage(),
        'success' => ''
      ]);
    }
  }

  private function handleFinalSave($params): Response
  {
    $config = $this->buildConfig($params);
    $tables = $this->buildTablesConfig($params);
    $config['tables'] = $tables;

    try {
      $this->bootstrap->saveConfig($config);

      return $this->render('framework/database-wizard.html.twig', [
        'step' => 6,
        'config' => $config,
        'tables' => $tables,
        'error' => '',
        'success' => 'Configuración guardada exitosamente'
      ]);
    } catch (\Exception $e) {
      return $this->render('framework/database-wizard.html.twig', [
        'step' => 5,
        'config' => $config,
        'tables' => $tables,
        'error' => 'Error al guardar la configuración: ' . $e->getMessage(),
        'success' => ''
      ]);
    }
  }

  private function buildConfig($params): array
  {
    $driver = $params['driver'] ?? '';

    $config = [
      'driver' => $driver,
      'host' => $params['host'] ?? 'localhost',
      'port' => (int)($params['port'] ?? $this->getDefaultPort($driver)),
      'database' => $params['database'] ?? '',
      'username' => $params['username'] ?? '',
      'password' => $params['password'] ?? '',
      'charset' => $params['charset'] ?? 'utf8mb4',
      'collation' => $params['collation'] ?? 'utf8mb4_unicode_ci'
    ];

    if ($config['driver'] === 'sqlite') {
      $config['database'] = $params['sqlite_path'] ?? 'database/app.sqlite';
      $config['host'] = '';
      $config['port'] = '';
      $config['username'] = '';
      $config['password'] = '';
    }

    return $config;
  }

  private function getDefaultPort($driver): int
  {
    return match ($driver) {
      'mysql' => 3306,
      'pgsql' => 5432,
      'sqlsrv' => 1433,
      default => 3306
    };
  }

  private function validateConfig($config): array
  {
    if (empty($config['driver'])) {
      return ['valid' => false, 'error' => 'Debe seleccionar un driver de base de datos'];
    }

    if ($config['driver'] === 'sqlite') {
      if (empty($config['database'])) {
        return ['valid' => false, 'error' => 'Debe especificar la ruta del archivo SQLite'];
      }
    } else {
      if (empty($config['host'])) {
        return ['valid' => false, 'error' => 'Debe especificar el servidor'];
      }
      if (empty($config['database'])) {
        return ['valid' => false, 'error' => 'Debe especificar el nombre de la base de datos'];
      }
      if (empty($config['username'])) {
        return ['valid' => false, 'error' => 'Debe especificar el usuario'];
      }
    }

    return ['valid' => true, 'error' => ''];
  }

  private function buildTablesConfig($params): array
  {
    $tables = [];

    if (isset($params['table_names']) && is_array($params['table_names'])) {
      foreach ($params['table_names'] as $index => $tableName) {
        if (empty(trim($tableName))) continue;

        $table = [
          'name' => trim($tableName),
          'fields' => []
        ];

        if (isset($params['field_names'][$index]) && is_array($params['field_names'][$index])) {
          foreach ($params['field_names'][$index] as $fieldIndex => $fieldName) {
            if (empty(trim($fieldName))) continue;

            $field = [
              'name' => trim($fieldName),
              'type' => $params['field_types'][$index][$fieldIndex] ?? 'VARCHAR',
              'length' => trim($params['field_lengths'][$index][$fieldIndex] ?? ''),
              'nullable' => isset($params['field_nullable'][$index][$fieldIndex]),
              'primary_key' => isset($params['field_primary'][$index][$fieldIndex]),
              'auto_increment' => isset($params['field_auto_increment'][$index][$fieldIndex])
            ];

            // Validation: Auto increment fields should be INT and PRIMARY KEY
            if ($field['auto_increment']) {
              $field['type'] = 'INT';
              $field['primary_key'] = true;
              $field['nullable'] = false;
            }

            // Validation: Primary keys should not be nullable
            if ($field['primary_key']) {
              $field['nullable'] = false;
            }

            $table['fields'][] = $field;
          }
        }

        // Ensure table has at least one field
        if (count($table['fields']) > 0) {
          $tables[] = $table;
        }
      }
    }

    return $tables;
  }

  private function createDatabase($config): void
  {
    // Connect without database to create it
    $tempConfig = $config;
    unset($tempConfig['database']);

    $factory = new ConnectionFactory();
    $connection = $factory->create($tempConfig);

    $dbName = $config['database'];
    $charset = $config['charset'] ?? 'utf8mb4';

    switch ($config['driver']) {
      case 'mysql':
        $sql = "CREATE DATABASE IF NOT EXISTS `{$dbName}` CHARACTER SET {$charset}";
        break;
      case 'pgsql':
        try {
          $sql = "CREATE DATABASE \"{$dbName}\"";
          $connection->execute($sql);
          return;
        } catch (\Exception $e) {
          if (strpos($e->getMessage(), 'already exists') === false) {
            throw $e;
          }
          return;
        }
      case 'sqlsrv':
        $sql = "IF NOT EXISTS(SELECT * FROM sys.databases WHERE name = '{$dbName}') CREATE DATABASE [{$dbName}]";
        break;
      default:
        throw new \Exception("Database creation not supported for driver: {$config['driver']}");
    }

    $connection->execute($sql);
  }

  private function createCustomTable($connection, $table, $driver): void
  {
    $tableName = $table['name'];
    $fields = $table['fields'];

    if (empty($fields)) {
      throw new \Exception("La tabla '$tableName' debe tener al menos un campo");
    }

    // Different quote styles for different drivers
    $quote = match ($driver) {
      'mysql' => '`',
      'pgsql' => '"',
      'sqlsrv' => '[',
      'sqlite' => '`',
      default => '`'
    };

    $closeQuote = match ($driver) {
      'sqlsrv' => ']',
      default => $quote
    };

    $sql = "CREATE TABLE IF NOT EXISTS {$quote}{$tableName}{$closeQuote} (";
    $fieldSql = [];

    foreach ($fields as $field) {
      $fieldDef = $this->buildFieldDefinition($field, $driver);
      $fieldSql[] = $fieldDef;
    }

    $sql .= implode(', ', $fieldSql);
    $sql .= ")";

    // Add engine and charset for MySQL
    if ($driver === 'mysql') {
      $sql .= " ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    }

    $connection->execute($sql);
  }

  private function buildFieldDefinition($field, $driver): string
  {
    $name = $field['name'];
    $type = $field['type'];
    $length = $field['length'];
    $nullable = $field['nullable'];
    $primaryKey = $field['primary_key'];
    $autoIncrement = $field['auto_increment'];

    // Different quote styles for different drivers
    $quote = match ($driver) {
      'mysql' => '`',
      'pgsql' => '"',
      'sqlsrv' => '[',
      'sqlite' => '`',
      default => '`'
    };

    $closeQuote = match ($driver) {
      'sqlsrv' => ']',
      default => $quote
    };

    $definition = "{$quote}{$name}{$closeQuote} ";

    // Build type with length
    switch (strtoupper($type)) {
      case 'VARCHAR':
        $len = $length ?: '255';
        $definition .= "VARCHAR($len)";
        break;
      case 'INT':
        if ($driver === 'sqlite') {
          $definition .= "INTEGER";
        } else {
          $len = $length ? "($length)" : '';
          $definition .= "INT$len";
        }
        break;
      case 'TEXT':
        $definition .= "TEXT";
        break;
      case 'DATETIME':
        $definition .= ($driver === 'sqlsrv') ? "DATETIME2" : "DATETIME";
        break;
      case 'TIMESTAMP':
        $definition .= "TIMESTAMP";
        break;
      case 'DECIMAL':
        $len = $length ?: '10,2';
        $definition .= "DECIMAL($len)";
        break;
      default:
        $definition .= $type;
        break;
    }

    // Nullable
    if (!$nullable) {
      $definition .= " NOT NULL";
    }

    // Auto increment (driver specific)
    if ($autoIncrement) {
      switch ($driver) {
        case 'mysql':
          $definition .= " AUTO_INCREMENT";
          break;
        case 'pgsql':
          // PostgreSQL uses SERIAL instead
          $definition = "{$quote}{$name}{$closeQuote} SERIAL";
          break;
        case 'sqlite':
          // SQLite AUTOINCREMENT only for INTEGER PRIMARY KEY
          if ($primaryKey) {
            $definition .= " AUTOINCREMENT";
          }
          break;
        case 'sqlsrv':
          $definition .= " IDENTITY(1,1)";
          break;
        default:
          // No auto increment for unknown drivers
          break;
      }
    }

    // Primary key
    if ($primaryKey) {
      $definition .= " PRIMARY KEY";
    }

    return $definition;
  }
}
