<?php

use App\Controllers\AgeController;

return [
  ['GET', '/api/age', [AgeController::class, 'index']],
  ['POST', '/api/age', [AgeController::class, 'predict']]
];
