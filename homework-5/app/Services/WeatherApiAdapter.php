<?php

namespace App\Services;

use App\Factories\ApiAdapterFactory;

class WeatherApiAdapter implements ApiAdapterInterface
{
  public function fetch(?array $params = []): array
  {
    $country = urlencode($this->getLocation());

    $url = "https://wttr.in/$country?format=j1";

    $res = @file_get_contents($url);

    $data = json_decode($res);

    return [
      'current' => $data->current_condition[0],
      'temp_C' => $data->current_condition[0],
      'temp_F' => $data->current_condition[0],
      'weather_desc' => $data->current_condition[0]->weatherDesc[0]->value
    ];
  }

  private function getLocation(): string
  {
    $ip = ApiAdapterFactory::create('ip');
    $data = $ip->fetch();

    $country = $data['country'];


    return $country;
  }
}
