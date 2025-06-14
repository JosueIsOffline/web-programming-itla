<?php

use App\Controllers\PersonajeController;
use App\Controllers\ProfesionController;

return [
  ['GET', '/', [PersonajeController::class, 'index']],
  ['GET', '/profesions/create', [ProfesionController::class, 'create']],
  ['POST', '/profesions', [ProfesionController::class, 'store']],
  ['GET', '/dashboard', [PersonajeController::class, 'dashboard']]
];
