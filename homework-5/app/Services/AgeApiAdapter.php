<?php

namespace App\Services;


class AgeApiAdapter implements ApiAdapterInterface
{
  public function fetch(array $params): array
  {
    if (!isset($params['name']) || empty($params['name'])) {
      throw new \InvalidArgumentException('Name is required!');
    }

    $name = urlencode($params['name']);

    $url = "https://api.agify.io/?name=$name";

    $res = @file_get_contents($url);

    $data = json_decode($res, true);

    $emoji = $this->getEmoji($data['age'] ?? 0);

    return [
      'name' => $data['name'],
      'age' => $data['age'] ?? 0,
      'count' => $data['count'],
      'emoji' => $emoji
    ];
  }

  private function getEmoji(int $age): string
  {
    if ($age <= 18) {
      return '👶';
    } elseif ($age <= 60) {
      return '🧑';
    }

    return '👴';
  }
}
