<?php

use App\Controllers\UniversitiesController;

return [
  ['GET', '/api/universities', [UniversitiesController::class, 'index']],
  ['POST', '/api/universities', [UniversitiesController::class, 'search']]
];
