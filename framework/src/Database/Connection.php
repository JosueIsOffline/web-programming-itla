<?php

namespace JosueIsOffline\Framework\Database;

use PDO;
use PDOException;
use JosueIsOffline\Framework\Database\DatabaseException;


class Connection
{
  private static ?Connection $instance = null;
  private ?PDO $pdo = null;
  private array $config = [];

  private function __construct(array $config)
  {
    $this->config = $config;
    $this->connect();
  }

  public static function create(array $config): static
  {
    if (static::$instance === null) {
      static::$instance = new static($config);
    }

    return static::$instance;
  }

  public static function getInstance(): ?static
  {
    return static::$instance;
  }

  private function connect(): void
  {
    try {
      $dsn = $this->buildDsn();
      $options = $this->getDefaultOptions();


      $this->pdo = new PDO(
        $dsn,
        $this->config['username'] ?? '',
        $this->config['password'] ?? '',
        $options
      );
    } catch (PDOException $e) {
      throw new DatabaseException("Something went wrong while connecting to database: " . $e->getMessage());
    }
  }

  private function buildDsn(): string
  {


    $driver = $this->config['driver'] ?? 'mysql';
    $host = $this->config['host'] ?? 'localhost';
    $port = $this->config['port'] ?? 3306;
    $database = $this->config['database'] ?? '';
    $charset = $this->config['charset'] ?? 'utf8mb4';



    switch ($driver) {
      case 'mysql':
        return "mysql:host={$host};port={$port};dbname={$database};charset={$charset};";
      default:
        throw new DatabaseException("This driver '$driver' doesn't exist");
    }
  }

  private function getDefaultOptions(): array
  {
    return [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::ATTR_EMULATE_PREPARES => false,
    ];
  }

  public function getPdo(): PDO
  {
    if ($this->pdo === null) $this->connect();

    return $this->pdo;
  }

  public function query(string $sql, array $params = []): \PDOStatement
  {
    try {
      $stmt = $this->getPdo()->prepare($sql);
      $stmt->execute($params);
      return $stmt;
    } catch (PDOException $e) {
      throw new DatabaseException("Error en la consulta: " . $e->getMessage() . " SQL: {$sql}");
    }
  }


  public function fetchAll(string $sql, array $params = []): array
  {
    return $this->query($sql, $params)->fetchAll();
  }


  public function fetchOne(string $sql, array $params = []): ?array
  {
    $result = $this->query($sql, $params)->fetch();
    return $result ?: null;
  }


  public function execute(string $sql, array $params = []): bool
  {
    return $this->query($sql, $params)->rowCount() > 0;
  }
  public function lastInsertId(): string
  {
    return $this->getPdo()->lastInsertId();
  }

  public function beginTransaction(): bool
  {
    return $this->getPdo()->beginTransaction();
  }

  public function commit(): bool
  {
    return $this->getPdo()->commit();
  }

  public function rollback(): bool
  {
    return $this->getPdo()->rollback();
  }

  public function inTransaction(): bool
  {
    return $this->getPdo()->inTransaction();
  }
}
