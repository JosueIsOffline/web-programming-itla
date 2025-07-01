<?php

namespace JosueIsOffline\Framework\Database;

class QueryBuilder
{
  private Connection $connection;
  private string $table = '';
  private array $select = ['*'];
  private array $where = [];
  private array $joins = [];
  private array $orderBy = [];
  private array $groupBy = [];
  private ?string $having = null;
  private ?int $limit = null;
  private ?int $offset = null;
  private array $bindings = [];

  public function __construct(Connection $connection)
  {
    $this->connection = $connection;
  }

  public function table(string $table): self
  {
    $this->table = $table;
    return $this;
  }

  public function select(...$columns): self
  {
    $this->select = empty($columns) ? ['*'] : $columns;
    return $this;
  }

  public function get(): array
  {
    $sql = $this->buildSelectQuery();
    return $this->connection->fetchAll($sql, $this->bindings);
  }


  private function buildSelectQuery(): string
  {
    $sql = "SELECT " . implode(', ', $this->select) . " FROM {$this->table}";

    if (!empty($this->joins)) {
      $sql .= " " . implode(' ', $this->joins);
    }

    if (!empty($this->where)) {
      $sql .= " WHERE " . implode(' AND ', $this->where);
    }

    if (!empty($this->groupBy)) {
      $sql .= " GROUP BY " . implode(', ', $this->groupBy);
    }

    if ($this->having !== null) {
      $sql .= " HAVING {$this->having}";
    }

    if (!empty($this->orderBy)) {
      $sql .= " ORDER BY " . implode(', ', $this->orderBy);
    }

    if ($this->limit !== null) {
      $sql .= " LIMIT {$this->limit}";
    }

    if ($this->offset !== null) {
      $sql .= " OFFSET {$this->offset}";
    }

    return $sql;
  }
}
