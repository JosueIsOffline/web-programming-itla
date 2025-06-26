<?php

namespace App\Factories;

use App\Services\AgeApiAdapter;
use App\Services\ApiAdapterInterface;
use App\Services\CountriesApiAdapter;
use App\Services\CurrencyApiAdapter;
use App\Services\GenderApiAdapter;
use App\Services\ImageApiAdapter;
use App\Services\IpApiAdapter;
use App\Services\JokesApiAdapter;
use App\Services\NewsApiAdapter;
use App\Services\PokemonApiAdapter;
use App\Services\UniversitiesApiAdapter;
use App\Services\WeatherApiAdapter;

class ApiAdapterFactory
{
  public static function create(string $type): ApiAdapterInterface
  {
    return match ($type) {
      'gender' => new GenderApiAdapter(),
      'age' => new AgeApiAdapter(),
      'universities' => new UniversitiesApiAdapter(),
      'countries' => new CountriesApiAdapter(),
      'pokemon' => new PokemonApiAdapter(),
      'image' => new ImageApiAdapter(),
      'jokes' => new JokesApiAdapter(),
      'currency' => new CurrencyApiAdapter(),
      'news' => new NewsApiAdapter(),
      'weather' => new WeatherApiAdapter(),
      'ip' => new IpApiAdapter(),
      default => throw new \Exception("There is no adapter to '$type'"),
    };
  }
}
