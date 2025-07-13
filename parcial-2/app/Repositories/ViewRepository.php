<?php

namespace App\Repositories;

use App\Models\View;

class ViewRepository implements IRepository
{
  public function getAll(): ?array
  {
    return View::all();
  }

  public function getById(int $id): View
  {
    return View::find($id);
  }

  public function add(array $data): void
  {
    $view = new View();
    $view->create($data);
  }

  public function edit(array $data): void
  {
    $view = new View();
    $view->update($data);
  }

  public function delete(int $id): void
  {
    $view = new View();
    $view->delete($id);
  }
}
