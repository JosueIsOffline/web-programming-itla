<?php

namespace App\Controllers;

use App\Factories\ApiAdapterFactory;
use JosueIsOffline\Framework\Controllers\AbstractController;
use JosueIsOffline\Framework\Http\Response;

class JokesController extends AbstractController
{
  public function index(): Response
  {
    $jokes = ApiAdapterFactory::create('jokes');

    $data = $jokes->fetch();

    return $this->render('jokes.html.twig', [
      'joke' => $data
    ]);
  }
}
