<?php

namespace App\Controllers\Api;

use App\Repositories\ClientRepository;
use JosueIsOffline\Framework\Controllers\AbstractController;
use JosueIsOffline\Framework\Http\Response;

class ClientController extends AbstractController
{
  public function findByCode(string $code): Response
  {
    $repo = new ClientRepository();
    $client = $repo->findByCode($code);

    return $this->success(
      $client,
      '',
      201
    );
  }
}
