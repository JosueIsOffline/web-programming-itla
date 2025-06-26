<?php

use App\Controllers\NewsController;

return [
  ['GET', '/api/news', [NewsController::class, 'index']]
];
