<?php

use App\Controllers\ImageController;

return [
  ['GET', '/api/images', [ImageController::class, 'index']],
  ['POST', '/api/images', [ImageController::class, 'create']]
];
