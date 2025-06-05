<?php

namespace App\Repositories;

use App\Models\Profesion;

class ProfesionesRepository
{
  public function getAll(): array
  {
    $jsonData = file_get_contents(__DIR__ . '/../../data/profesiones.json');
    $arrayProfesiones = json_decode($jsonData, true);

    $profesiones = [];


    $profesiones = $this->mapListToProfesiones($arrayProfesiones);


    return $profesiones;
  }

  public function add(Profesion $ps): void
  {
    $profesiones = $this->getAll();
    $profesionName = $ps->getName();

    foreach ($profesiones as $profesion) {
      if ($profesion->getName() === $profesionName) {
        echo "Esa profesion ya existe";
        return;
      }
    }

    $profesiones[] = $ps;
    $jsonData = json_encode($profesiones, JSON_PRETTY_PRINT);
    file_put_contents(__DIR__ . "/../../data/profesiones.json", $jsonData);
  }


  public function mapArrayToProfesiones(array $ps): ?Profesion
  {
    $profesion = new Profesion();

    $profesion->setName($ps['nombre']);
    $profesion->setCategory($ps['categoria']);
    $profesion->setSalary($ps['salario']);

    return $profesion;
  }

  private function mapListToProfesiones(array $list): array
  {
    $profesiones = [];

    foreach ($list as $ps) {
      $profesion = $this->mapArrayToProfesiones($ps);
      if ($profesion != null) {
        $profesiones[] = $profesion;
      }
    }

    return $profesiones;
  }
}
