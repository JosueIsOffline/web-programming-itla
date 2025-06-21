<?php

namespace App\Controllers;

use App\Factories\ApiAdapterFactory;
use JosueIsOffline\Framework\Controllers\AbstractController;
use JosueIsOffline\Framework\Http\Response;

class CountriesController extends AbstractController
{
  public function index(): Response
  {
    return $this->render('countries.html.twig');
  }

  public function search(): Response
  {

    $params = $this->request->getAllPost();

    $countries = ApiAdapterFactory::create('countries');
    $data = $countries->fetch($params);

    return $this->render('countries.html.twig', [
      "country" => $data,
      "countryName" => $params['country'],
    ]);
  }
}
