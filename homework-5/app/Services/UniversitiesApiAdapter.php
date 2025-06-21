<?php

namespace App\Services;

class UniversitiesApiAdapter implements ApiAdapterInterface
{
  public function fetch(array $params): array
  {
    if (!isset($params['country']) || empty($params['country'])) {
      throw new \InvalidArgumentException("'Country' parameter is required!");
    }

    $country = urlencode($params['country']);
    $url = "http://universities.hipolabs.com/search?country=$country";

    $res = @file_get_contents($url);

    if (!$res) throw new \Exception("Somethig went wrong!");

    $data = json_decode($res, true);

    $universities = [];

    foreach ($data as $item) {
      $universities[] = [
        'name' => $item['name'] ?? 'N/A',
        'domains' => $item['domains'][0] ?? 'N/A',
        'country' => $item['country'] ?? 'N/A',
        'state-province' => $item['state-province'] ?? 'N/A',
        'web_pages' => $item['web_pages'][0] ?? 'N/A',
      ];
    }

    return $universities;
  }
}
