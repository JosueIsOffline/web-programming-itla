<?php

use App\Controllers\JokesController;

return [
  ['GET', '/api/jokes', [JokesController::class, 'index']]
];
