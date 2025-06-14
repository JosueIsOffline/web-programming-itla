<?php

use App\Controllers\PacientControllers;

return [
  ['GET', '/patients', [PacientControllers::class, 'list']],
  ['GET', '/new/patient', [PacientControllers::class, 'create']],
  ['POST', '/new/patient', [PacientControllers::class, 'store']]
];
