<?php

namespace App\Controllers;

use App\Factories\ApiAdapterFactory;
use JosueIsOffline\Framework\Controllers\AbstractController;
use JosueIsOffline\Framework\Http\Response;

class NewsController extends AbstractController
{
  public function index(): Response
  {

    $news = ApiAdapterFactory::create('news');

    $data = $news->fetch(['website' => 'TechCrunch']);

    return $this->render('new.html.twig', [
      'news' => $data
    ]);
  }
}
