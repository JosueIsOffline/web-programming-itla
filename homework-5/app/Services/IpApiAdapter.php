<?php

namespace App\Services;

class IpApiAdapter implements ApiAdapterInterface
{

  public function fetch(?array $params = []): array
  {
    $url = "http://ip-api.com/json/";

    $res = @file_get_contents($url);

    $data = json_decode($res);

    return [
      'country' => $data->country
    ];
  }
}
