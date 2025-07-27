<?php

use App\Controllers\Api\ClientController as ApiClientController;

return [
  ['GET', '/api/clients/{code:.+}', [ApiClientController::class, 'findByCode']]
];
