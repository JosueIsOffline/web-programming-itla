<?php

use App\Controllers\CurrencyController;

return [
  ['GET', '/api/currency', [CurrencyController::class, 'index']],
  ['POST', '/api/currency', [CurrencyController::class, 'convert']]
];
