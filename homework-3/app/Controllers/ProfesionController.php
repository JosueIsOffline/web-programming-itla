<?php

namespace App\Controllers;

use App\Repositories\ProfesionesRepository;
use JosueIsOffline\Framework\Controllers\AbstractController;
use JosueIsOffline\Framework\Http\Response;

class ProfesionController extends AbstractController
{

  public function create(): Response
  {
    $repo = new ProfesionesRepository();
    $profesiones = $repo->getAll();
    return $this->render('createp.html.twig', [
      'profesiones' => $profesiones,
    ]);
  }

  public function store(): Response
  {
    $repo = new ProfesionesRepository();
    $profesion = $repo->mapArrayToProfesiones($this->request->getAllPost());
    $repo->add($profesion);


    return $this->render('createp.html.twig', [
      'message' => 'Profesion creada con exito!',
    ]);
  }
}
