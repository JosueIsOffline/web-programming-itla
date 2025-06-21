<?php

use App\Controllers\GenderController;

return [
  ['GET', '/api/gender', [GenderController::class, 'index']],
  ['POST', '/api/gender', [GenderController::class, 'predict']]
];
