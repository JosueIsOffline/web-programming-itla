<?php

use App\Controllers\PersonajeController;

return [
  ['GET', '/', [PersonajeController::class, 'index']],
  ['GET', '/create', [PersonajeController::class, 'create']],
  ['GET', '/{id:\d+}/edit', [PersonajeController::class, 'update']],
  ['POST', '/create', [PersonajeController::class, 'store']],
  ['POST', '/{id:\d+}/edit', [PersonajeController::class, 'update']],
  ['POST', '/delete/{id:\d+}', [PersonajeController::class, 'delete']]
];
