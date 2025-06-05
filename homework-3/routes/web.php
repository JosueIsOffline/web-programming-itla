<?php

use App\Controllers\PersonajeController;
use App\Controllers\ProfesionController;

return [
  ['GET', '/', [PersonajeController::class, 'index']],
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
  ['GET', '/profesions/create', [ProfesionController::class, 'create']],
  ['POST', '/profesions', [ProfesionController::class, 'store']],
  ['GET', '/dashboard', [PersonajeController::class, 'dashboard']]
];
