<?php

use App\Controllers\PersonajeController;

return [
  ['GET', '/personajes', [PersonajeController::class, 'list']],
  [
    'GET',
    '/personajes/create',
    [PersonajeController::class, 'create']
  ],
  ['GET', '/personajes/edit/{id:\d+}', [PersonajeController::class, 'edit']],
  ['POST', '/personajes/edit', [PersonajeController::class, 'update']],
  ['POST', '/personajes', [PersonajeController::class, 'store']],
  ['DELETE', '/personajes/{id:\d+}', [PersonajeController::class, 'delete']],
];
