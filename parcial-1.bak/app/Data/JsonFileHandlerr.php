<?php

namespace App\Data;

use App\Models\Pacient;

class JsonFileHandler
{
  private static array $instances = [];

  private array $data = [];
  private string $filePath;

  private function __construct(string $filePath)
  {
    $this->filePath = $filePath;
    $this->load();
  }

  public static function getInstance(string $filePath): self
  {
    if (!isset(self::$instances[$filePath])) {
      self::$instances[$filePath] = new self($filePath);
    }

    return self::$instances[$filePath];
  }

  private function load(): void
  {
    if (!file_exists($this->filePath)) {
      $this->data = [];
      return;
    }

    $json = file_get_contents($this->filePath);
    $this->data = json_decode($json, true) ?? [];
  }

  public function getData(): array
  {
    return $this->data;
  }

  public function setData(array $data): void
  {
    $this->data = $data;
  }

  public function save(): void
  {
    file_put_contents($this->filePath, json_encode($this->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
  }

  public function reload(): void
  {
    $this->load();
  }
}
