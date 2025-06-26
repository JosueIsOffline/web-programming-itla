<?php

namespace App\Services;

class ImageApiAdapter implements ApiAdapterInterface
{
  public function fetch(?array $params = []): array
  {

    $prompt = $params['prompt'];
    $apiToken = $_ENV['API_TOKEN_CLOUDFLARE'];
    $accountId = $_ENV['ACCOUNT_ID_CLOUDFLARE'];

    $url = "https://api.cloudflare.com/client/v4/accounts/$accountId/ai/run/@cf/black-forest-labs/flux-1-schnell";

    $body = [
      'prompt' => $prompt,
      'seed' => random_int(1, PHP_INT_MAX)
    ];

    $ch = curl_init($url);
    curl_setopt_array($ch, [
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_POST => true,
      CURLOPT_HTTPHEADER => [
        "Authorization: Bearer $apiToken",
        "Content-Type: application/json"
      ],
      CURLOPT_POSTFIELDS => json_encode($body)
    ]);

    $res = curl_exec($ch);

    if (curl_errno($ch)) {
      echo 'Error: ' . curl_error($ch);
      curl_close($ch);
      exit;
    }

    $data = json_decode($res, true);

    $imageBase64 = $data['result']['image'] ?? null;

    $currentDate = date('Y-m-d');

    if (!$imageBase64) throw new \Exception('Image could not be generated.');

    return [
      'image_data' => $imageBase64,
      'generated_at' => $currentDate,
      'seed' => $body['seed'],
      'prompt' => $body['prompt']
    ];
  }
}
