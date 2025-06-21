<?php

namespace App\Controllers;

use App\Factories\ApiAdapterFactory;
use JosueIsOffline\Framework\Controllers\AbstractController;
use JosueIsOffline\Framework\Http\Response;

class GenderController extends AbstractController
{

  public function index(): Response
  {
    return $this->render('gender.html.twig');
  }

  public function predict(): Response
  {
    $params = $this->request->getAllPost() ?? '';

    try {
      $gender = ApiAdapterFactory::create('gender');

      $data = $gender->fetch($params);

      return $this->render('gender.html.twig', [
        'result' => $data
      ]);
    } catch (\Exception $e) {
      return $this->render('gender.html.twig', [
        'error' => 'We could not get the prediction. Try again.'
      ]);
    }
  }
}
