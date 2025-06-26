<?php

use App\Controllers\WeatherController;

return [
  ['GET', '/api/weather', [WeatherController::class, 'index']]
];
