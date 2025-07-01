<?php

return [
  'default' => 'mysql',

  'connections' => [
    'mysql' => [
      'driver' => 'mysql',
      'host' => $_ENV['DB_HOST'] ?? 'localhost',
      'port' => $_ENV['DB_PORT'] ?? 3306,
      'database' => $_ENV['DB_DATABASE'] ?? 'framework',
      'username' => $_ENV['DB_USERNAME'] ?? 'root',
      'password' => $_ENV['DB_PASSWORD'] ?? '',
      'charset' => 'utf8mb4',
      'collation' => 'utf8mb4_unicode_ci',
    ],

    'pgsql' => [
      'driver' => 'pgsql',
      'host' => $_ENV['DB_HOST'] ?? 'localhost',
      'port' => $_ENV['DB_PORT'] ?? 5432,
      'database' => $_ENV['DB_DATABASE'] ?? 'mi_framework',
      'username' => $_ENV['DB_USERNAME'] ?? 'postgres',
      'password' => $_ENV['DB_PASSWORD'] ?? '',
    ],

    'sqlite' => [
      'driver' => 'sqlite',
      'database' => $_ENV['DB_DATABASE'] ?? BASE_PATH . '/database/database.sqlite',
    ],
  ],
];
