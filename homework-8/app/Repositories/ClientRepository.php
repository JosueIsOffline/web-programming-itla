<?php

namespace App\Repositories;

use App\Models\Client;

class ClientRepository
{
  public function findByCode(string $code): array
  {
    $client = new Client();
    return $client->query()->where('codigo', $code)->first();
  }
}
