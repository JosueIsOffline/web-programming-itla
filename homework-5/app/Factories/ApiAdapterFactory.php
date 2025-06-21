<?php

namespace App\Factories;

use App\Services\AgeApiAdapter;
use App\Services\ApiAdapterInterface;
use App\Services\CountriesApiAdapter;
use App\Services\GenderApiAdapter;
use App\Services\UniversitiesApiAdapter;

class ApiAdapterFactory
{
  public static function create(string $type): ApiAdapterInterface
  {
    return match ($type) {
      'gender' => new GenderApiAdapter(),
      'age' => new AgeApiAdapter(),
      'universities' => new UniversitiesApiAdapter(),
      'countries' => new CountriesApiAdapter(),
      default => throw new \Exception("There is no adapter to '$type'"),
    };
  }
}
