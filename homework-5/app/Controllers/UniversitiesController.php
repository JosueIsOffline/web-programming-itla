<?php

namespace App\Controllers;

use App\Factories\ApiAdapterFactory;
use JosueIsOffline\Framework\Controllers\AbstractController;
use JosueIsOffline\Framework\Http\Response;

class UniversitiesController extends AbstractController
{
  public function index(): Response
  {
    return $this->render('universities.html.twig');
  }

  public function search(): Response
  {
    $params = $this->request->getAllPost();

    try {
      $universities = ApiAdapterFactory::create('universities');
      $data = $universities->fetch($params);

      return $this->render('universities.html.twig', [
        'universities' => $data,
        'country' => $params['country']
      ]);
    } catch (\Exception $e) {
      return $this->render('universities.html.twig', [
        'error' => 'Something went wrong with the request. Try Again.'
      ]);
    }
  }
}
