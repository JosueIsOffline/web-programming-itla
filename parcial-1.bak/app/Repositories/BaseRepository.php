<?php

namespace App\Repositories;

use App\Models\Pacient;

abstract class BaseRepository
{
  abstract public function getAll(): array;
  abstract public function getById(int $id): ?Pacient;
  abstract public function add(Pacient $p): void;
  abstract public function edit(Pacient $p): void;
  abstract public function delete(int $id): void;
}
