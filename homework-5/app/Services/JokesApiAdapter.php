<?php

namespace App\Services;


class JokesApiAdapter implements ApiAdapterInterface
{

  public function fetch(?array $params = []): array
  {
    $url = "https://official-joke-api.appspot.com/random_joke";

    $res = @file_get_contents($url);

    $data = json_decode($res, true);

    return $data;
  }
}
