<?php

namespace JosueIsOffline\Framework\Database;

class DB
{
  private static ?Connection $connection = null;

  public static function configure(array $config): void
  {
    static::$connection = Connection::create($config);
  }

  public static function connection(): Connection
  {
    if (static::$connection === null) {
      throw new DatabaseException("La conexión a la base de datos no ha sido configurada. Llama a DB::configure() primero.");
    }

    return static::$connection;
  }

  public static function table(string $table): QueryBuilder
  {
    return (new QueryBuilder(static::connection()))->table($table);
  }
}
