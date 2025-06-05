<?php

namespace App\Repositories;

use App\Helpers\Mapper;
use App\Models\Personaje;
use App\Models\Profesion;
use DateTime;

class InMemoryPersonajeRepository extends PersonajeRepository
{


  public function getAll(): array
  {
    $personajes = [];
    $jsonData = file_get_contents(__DIR__ . '/../../data/personajes.json');

    $arrayPersonajes = json_decode($jsonData, true);

    $personajes = $this->mapListToPersonajes($arrayPersonajes);

    return $personajes;
  }

  public function findById(int $id): ?Personaje
  {
    $personajes = $this->getAll();

    foreach ($personajes as $p) {
      if ($p->getId() === $id) {
        return $p;
      }
    }

    return null;
  }

  public function add(Personaje $p): void
  {
    $personajes = $this->getAll();
    $maxId = 0;

    foreach ($personajes as $personaje) {
      if ($personaje->getId() > $maxId) {
        $maxId = $personaje->getId();
      }
    }
    $newId = $maxId + 1;

    $p->setId($newId);
    $personajes[] = $p;

    $jsonData = json_encode($personajes, JSON_PRETTY_PRINT);

    file_put_contents(__DIR__ . '/../../data/personajes.json', $jsonData);
  }

  public function update(Personaje $p): void
  {
    $personajes = $this->getAll();

    foreach ($personajes as $index => $personaje) {
      if ($personaje->getId() === $p->getId()) {
        $personajes[$index] = $p;
        break;
      }
    }

    $jsonData = json_encode($personajes, JSON_PRETTY_PRINT);
    file_put_contents(__DIR__ . '/../../data/personajes.json', $jsonData);
  }

  public function delete(int $id): void
  {
    $personajes = $this->getAll();

    $personajes = array_filter($personajes, function ($personaje) use ($id) {
      return $personaje->getId() !== $id;
    });

    $personajes = array_values($personajes);

    $jsonData = json_encode($personajes, JSON_PRETTY_PRINT);
    file_put_contents(__DIR__ . '/../../data/personajes.json', $jsonData);
  }

  public function mapArrayToPersonaje(array $p): ?Personaje
  {
    $personaje = new Personaje();
    if (isset($p['id'])) {
      $personaje->setId($p['id']);
    }
    $personaje->setName($p['nombre']);
    $personaje->setLastName($p['apellido']);
    $personaje->setPhoto($p['foto']);
    $fechaNacimiento = DateTime::createFromFormat('Y-m-d', $p['fechaNacimiento']);
    if (!$fechaNacimiento) return null;

    $personaje->setBornDate($fechaNacimiento);
    $personaje->setLevelExperience($p['nivelExperiencia']);

    $profesionesArray = $p['profesiones'];

    $profesionesObj = [];
    if (!empty($profesionesArray) && is_array($profesionesArray[0])) {
      foreach ($profesionesArray as $profesionArray) {
        $profesionObj = Mapper::arrayToProfesion($profesionArray);
        if ($profesionObj !== null) {
          $profesionesObj[] = $profesionObj;
        }
      }
    } else {
      foreach ($profesionesArray as $nombreProfesion) {
        if (is_string($nombreProfesion) && $nombreProfesion !== '') {
          $data = Mapper::findProfesionByName($nombreProfesion);
          if ($data !== null) {
            $profesionObj = Mapper::arrayToProfesion($data);
            if ($profesionObj !== null) {
              $profesionesObj[] = $profesionObj;
            }
          }
        }
      }
    }


    $personaje->setProfessions($profesionesObj);
    return $personaje;
  }

  private function mapListToPersonajes(array $lista): array
  {
    $personajes = [];

    foreach ($lista as $p) {
      $personaje = $this->mapArrayToPersonaje($p);
      if ($personaje != null) {
        $personajes[] = $personaje;
      }
    }

    return $personajes;
  }
}
