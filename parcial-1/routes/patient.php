<?php

use App\Controllers\PatientController;

return [
  ['GET', '/', [PatientController::class, 'index']],
  ['GET', '/new/patient', [PatientController::class, 'create']],
  ['POST', '/patient', [PatientController::class, 'store']]
];
