<?php

namespace App\Services;

class CountriesApiAdapter implements ApiAdapterInterface
{
  public function fetch(?array $params = []): array
  {
    $country = $params['country'];
    $url = "https://restcountries.com/v3.1/name/$country";

    $res = @file_get_contents($url);

    $data = json_decode($res, true);

    return [
      "name" => $data[0]["name"],
      "flags" => $data[0]["flags"],
      "capital" => $data[0]["capital"],
      "region" => $data[0]["region"],
      "subregion" => $data[0]["subregion"],
      "population" => $data[0]["population"],
      "area" => $data[0]["area"],
      "currencies" => $data[0]["currencies"],
      "languages" => $data[0]["languages"],
      "timezones" => $data[0]["timezones"],
      "tld" => $data[0]["tld"],
      "cca2" => $data[0]["cca2"],
      "maps" => $data[0]["maps"]
    ];
  }
}
