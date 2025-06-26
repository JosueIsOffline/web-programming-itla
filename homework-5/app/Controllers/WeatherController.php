<?php

namespace App\Controllers;

use App\Factories\ApiAdapterFactory;
use JosueIsOffline\Framework\Controllers\AbstractController;
use JosueIsOffline\Framework\Http\Response;

class WeatherController extends AbstractController
{
  public function index(): Response
  {
    $weather = ApiAdapterFactory::create('weather');

    $data = $weather->fetch();
    return $this->render('weather.html.twig', [
      'weather' => $data
    ]);
  }
}
