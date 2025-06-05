<?php

namespace App\Repositories;

use App\Models\Personaje;

abstract class PersonajeRepository
{

  abstract public function getAll(): array;
  abstract public function findById(int $id): ?Personaje;
  abstract public function add(Personaje $p): void;
  abstract public function update(Personaje $p): void;
  abstract public function delete(int $id): void;
}
