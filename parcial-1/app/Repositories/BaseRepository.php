<?php

namespace App\Repositories;

use App\Models\Patient;

abstract class BaseRepository
{
  abstract public function getAll(): array;
  abstract public function getById(int $id): ?Patient;
  abstract public function add(Patient $p): void;
  abstract public function edit(Patient $p): void;
  abstract public function delete(int $id): void;
}
