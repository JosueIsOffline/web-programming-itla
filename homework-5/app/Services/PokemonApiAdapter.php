<?php

namespace App\Services;

class PokemonApiAdapter implements ApiAdapterInterface
{
  public function fetch(?array $params = []): array
  {
    $pokemon = $params['pokemon'];

    $url = "https://pokeapi.co/api/v2/pokemon/$pokemon";

    $res = @file_get_contents($url);

    $data = json_decode($res, true);

    return [
      'id' => $data['id'],
      'name' => $data['name'],
      'cries' => $data['cries'],
      'sprites' => $data['sprites'],
      'types' => $data['types'],
      'height' => $data['height'],
      'weight' => $data['weight'],
      'base_experience' => $data['base_experience'],
      'abilities' => $data['abilities'],
      'stats' => $data['stats'],
    ];
  }
}
