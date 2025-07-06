<?php

namespace App\Repositories;

use App\Models\Personaje;

class PersonajeRepository implements IRepository
{

  public function getAll(): ?array
  {
    return Personaje::all();;
  }

  public function getById(int $id): Personaje
  {
    return Personaje::find($id);
  }

  public function add(array $data): void
  {
    $pj = new Personaje();
    $pj->create($data);
  }

  public function update(array $data): void
  {
    $pj = new Personaje();
    $pj->update($data);
  }

  public function delete(int $id): void
  {
    $pj = new Personaje();
    $pj->delete($id);
  }
}
