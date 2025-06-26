<?php

namespace App\Services;

class CurrencyApiAdapter implements ApiAdapterInterface
{
  public function fetch(?array $params = []): array
  {
    $apiKey = $_ENV['API_KEY_EXCHANGERATE'];
    $base_price = $params['amount'];

    $url = "https://v6.exchangerate-api.com/v6/$apiKey/latest/USD";

    $res = @file_get_contents($url, true);

    $data = json_decode($res);

    if ($data->result === 'success') {
      $DOP_price = round(($base_price * $data->conversion_rates->DOP), 2);
      $EUR_price = round(($base_price * $data->conversion_rates->EUR), 2);
      $GBP_price = round(($base_price * $data->conversion_rates->GBP), 2);
      $JPY_price = round(($base_price * $data->conversion_rates->JPY), 2);
      $CAD_price = round(($base_price * $data->conversion_rates->CAD), 2);
      $AUD_price = round(($base_price * $data->conversion_rates->AUD), 2);

      $date = new \DateTime($data->time_last_update_utc);

      return [
        'amount' => $base_price,
        'date' => $date->format('Y-m-d'),
        'dop' => $DOP_price,
        'eur' => $EUR_price,
        'gbp' => $GBP_price,
        'jpy' => $JPY_price,
        'cad' => $CAD_price,
        'aud' => $AUD_price,
      ];
    }

    return [
      'error' => $data->result
    ];
  }
}
