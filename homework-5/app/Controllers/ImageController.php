<?php

namespace App\Controllers;

use App\Factories\ApiAdapterFactory;
use App\Services\ImageApiAdapter;
use JosueIsOffline\Framework\Controllers\AbstractController;
use JosueIsOffline\Framework\Http\Response;

class ImageController extends AbstractController
{
  public function index(): Response
  {
    return $this->render('image.html.twig');
  }

  public function create(): Response
  {
    $params = $this->request->getAllPost();
    $image = ApiAdapterFactory::create('image');
    $data = $image->fetch($params);

    return $this->render('image.html.twig', [
      'generatedImage' => $data,
      'prompt' => $params['prompt']
    ]);
  }
}
