<?php

namespace App\Helpers;

use App\Models\Profesion;

class Mapper
{
  public static function arrayToProfesion(array $ps): Profesion
  {
    $profesion = new Profesion();
    $profesion->setName($ps['nombre']);
    $profesion->setCategory($ps['categoria']);
    $profesion->setSalary($ps['salario']);

    return $profesion;
  }

  public static function findProfesionByName(string $name): ?array
  {
    $jsonData = file_get_contents(__DIR__ . '/../../data/profesiones.json');
    $profesiones = json_decode($jsonData, true);

    foreach ($profesiones as $p) {
      if (strtolower($p['nombre']) === strtolower($name)) {
        return $p;
      }
    }

    return null;
  }
}
