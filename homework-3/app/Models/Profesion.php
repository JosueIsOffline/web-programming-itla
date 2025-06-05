<?php

namespace App\Models;

use JsonSerializable;

class Profesion implements JsonSerializable
{
  private string $nombre;
  private string $categoria;
  private float $salario;

  public function jsonSerialize(): array
  {
    return [

      'nombre' => $this->nombre,
      'categoria' => $this->categoria,
      'salario' => $this->salario

    ];
  }


  public function getName(): string
  {
    return $this->nombre;
  }

  public function setName(string $name): void
  {
    $this->nombre = $name;
  }

  public function getCategory(): string
  {
    return $this->categoria;
  }

  public function setCategory(string $category): void
  {
    $this->categoria = $category;
  }

  public function getSalary(): float
  {
    return $this->salario;
  }

  public function setSalary(float $salary): void
  {
    $this->salario = $salary;
  }
}
