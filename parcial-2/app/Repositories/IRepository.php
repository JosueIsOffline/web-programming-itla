<?php

namespace App\Repositories;

use App\Models\View;

interface IRepository
{
  function getAll(): ?array;
  function getById(int $id): View;
  function add(array $data): void;
  function edit(array $data): void;
  function delete(int $id): void;
}
