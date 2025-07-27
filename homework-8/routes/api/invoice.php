<?php

use App\Controllers\Api\InvoiceController;

return [
  ['POST', '/invoice', [InvoiceController::class, 'store']]
];
