<?php

use App\Controllers\Web\InvoiceController as WebInvoiceController;

return [
  ['GET', '/new-invoice', [WebInvoiceController::class, "create"]]
];
