<?php

namespace App\Controllers;

use JosueIsOffline\Framework\Controllers\AbstractController;
use JosueIsOffline\Framework\Http\Response;

class WelcomeController extends AbstractController
{
  public function index(): Response
  {
    return new Response('<h1>Hello from Barbie World!</h1>');
  }
}
