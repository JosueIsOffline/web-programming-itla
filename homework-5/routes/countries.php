<?php

use App\Controllers\CountriesController;

return [
  ['GET', '/api/countries', [CountriesController::class, 'index']],
  ['POST', '/api/countries', [CountriesController::class, 'search']]
];
