<?php

use App\Controllers\PokemonController;

return [
  ['GET', '/api/pokemon', [PokemonController::class, 'index']],
  ['POST', '/api/pokemon', [PokemonController::class, 'search']]
];
