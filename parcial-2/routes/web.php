<?php

use App\Controllers\ViewController;

return [
  ['GET', '/', [ViewController::class, 'index']],
  ['GET', '/views', [ViewController::class, 'list']],
  ['GET', '/create/view', [ViewController::class, 'create']],
  ['GET', '/edit-view/{id:\d+}', [ViewController::class, 'edit']],
  ['POST', '/create/view', [ViewController::class, 'store']],
  ['POST', '/delete-view/{id:\d+}', [ViewController::class, 'delete']],
  ['POST', '/edit-view/{id:\d+}', [ViewController::class, 'edit']]
];
