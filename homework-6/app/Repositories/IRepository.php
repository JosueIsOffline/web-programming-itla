<?php

namespace App\Repositories;

use App\Models\Personaje;

interface IRepository
{
  function getAll(): ?array;
  function getById(int $id): Personaje;
  function add(array $data): void;
  function update(array $data): void;
  function delete(int $id): void;
}
