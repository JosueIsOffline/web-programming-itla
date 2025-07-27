<?php

use App\Controllers\Web\InvoiceController as WebInvoiceController;

return [
  ['GET', '/', [WebInvoiceController::class, 'index']],
  ['GET', '/new_invoice', [WebInvoiceController::class, 'create']]
];
