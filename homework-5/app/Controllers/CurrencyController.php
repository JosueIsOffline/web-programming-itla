<?php

namespace App\Controllers;

use App\Factories\ApiAdapterFactory;
use JosueIsOffline\Framework\Controllers\AbstractController;
use JosueIsOffline\Framework\Http\Response;

class CurrencyController extends AbstractController
{

  public function index(): Response
  {
    return $this->render('currency.html.twig');
  }

  public function convert(): Response
  {
    $params = $this->request->getAllPost();

    $currency = ApiAdapterFactory::create('currency');
    $data = $currency->fetch($params);

    return $this->render('currency.html.twig', [
      'result' => $data
    ]);
  }
}
