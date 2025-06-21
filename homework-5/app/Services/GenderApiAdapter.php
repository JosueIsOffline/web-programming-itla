<?php

namespace App\Services;

class GenderApiAdapter implements ApiAdapterInterface
{
  public function fetch(array $params): array
  {

    if (!isset($params['name']) || empty($params['name'])) {
      throw new \InvalidArgumentException('"Name" parameter is required!');
    }


    $name = urldecode($params["name"]);
    $url = "https://api.genderize.io/?name=$name";

    $res = @file_get_contents($url);

    if (!$res) throw new \Exception('We could not connect to the Genderize server. Try again later.');

    $data = json_decode($res, true);

    return [
      'name' => $data['name'],
      'gender' => $data['gender'],
      'probability' => $data['probability'],
      'count' => $data['count']
    ];
  }
}
