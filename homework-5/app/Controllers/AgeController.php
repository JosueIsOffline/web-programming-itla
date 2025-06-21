<?php

namespace App\Controllers;

use App\Factories\ApiAdapterFactory;
use JosueIsOffline\Framework\Controllers\AbstractController;
use JosueIsOffline\Framework\Http\Response;

class AgeController extends AbstractController
{
  public function index(): Response
  {
    return $this->render('age.html.twig');
  }

  public function predict(): Response
  {
    $params = $this->request->getAllPost();
    try {
      $age = ApiAdapterFactory::create('age');
      $data = $age->fetch($params);

      return $this->render('age.html.twig', [
        'result' => $data,
      ]);
    } catch (\Exception $e) {
      return $this->render('age.html.twig', [
        'error' => 'There was an error'
      ]);
    }
  }
}
