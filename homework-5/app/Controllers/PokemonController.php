<?php

namespace App\Controllers;

use App\Factories\ApiAdapterFactory;
use JosueIsOffline\Framework\Controllers\AbstractController;
use JosueIsOffline\Framework\Http\Response;

class PokemonController extends AbstractController
{
  public function index(): Response
  {
    return $this->render('pokemon.html.twig');
  }

  public function search(): Response
  {
    $params = $this->request->getAllPost();

    $pokemon = ApiAdapterFactory::create('pokemon');

    $data = $pokemon->fetch($params);

    return $this->render('pokemon.html.twig', [
      'pokemon' => $data,
      'pokemonName' => $params['pokemon']
    ]);
  }
}
