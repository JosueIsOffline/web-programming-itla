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
  private ?int $limt = null;
  private ?int $offset = null;
  private array $bidings = [];
}
