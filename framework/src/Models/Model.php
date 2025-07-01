<?php


namespace JosueIsOffline\Framework\Models;

use JosueIsOffline\Framework\Database\DB;
use JosueIsOffline\Framework\Database\QueryBuilder;

abstract class Model
{
  protected string $table = '';
  protected string $primaryKey = 'id';
  protected array $fillable = [];
  protected array $attributes = [];

  public function __construct(array $attributes = [])
  {
    $this->attributes = $attributes;

    if (empty($this->table)) {
      $this->table = $this->getTableName();
    }
  }

  /**
   * Obtener el nombre de la tabla basado en el nombre de la clase
   */
  protected function getTableName(): string
  {
    $className = (new \ReflectionClass($this))->getShortName();
    return strtolower($className) . 's';
  }

  /**
   * Crear un nuevo Query Builder para esta tabla
   */
  public static function query(): QueryBuilder
  {
    $instance = new static();
    return DB::table($instance->table);
  }

  /**
   * Obtener todos los registros
   */
  public static function all(): array
  {
    return static::query()->get();
  }

  /**
   * Encontrar un registro por ID
   */
  // public static function find(int $id): ?array
  // {
  //     return static::query()->where('id', $id)->first();
  // }

  /**
   * Crear un nuevo registro
   */
  // public static function create(array $data): bool
  // {
  //     return static::query()->insert($data);
  // }

  /**
   * Actualizar registros
   */
  // public function update(array $data): bool
  // {
  //     if (!isset($this->attributes[$this->primaryKey])) {
  //         throw new \Exception("No se puede actualizar un modelo sin clave primaria");
  //     }
  //
  //     return static::query()
  //         ->where($this->primaryKey, $this->attributes[$this->primaryKey])
  //         ->update($data);
  // }

  /**
   * Eliminar el registro actual
   */
  // public function delete(): bool
  // {
  //     if (!isset($this->attributes[$this->primaryKey])) {
  //         throw new \Exception("No se puede eliminar un modelo sin clave primaria");
  //     }
  //
  //     return static::query()
  //         ->where($this->primaryKey, $this->attributes[$this->primaryKey])
  //         ->delete();
  // }

  /**
   * Obtener un atributo
   */
  public function __get(string $key)
  {
    return $this->attributes[$key] ?? null;
  }

  /**
   * Establecer un atributo
   */
  public function __set(string $key, $value): void
  {
    $this->attributes[$key] = $value;
  }

  /**
   * Verificar si existe un atributo
   */
  public function __isset(string $key): bool
  {
    return isset($this->attributes[$key]);
  }
}
