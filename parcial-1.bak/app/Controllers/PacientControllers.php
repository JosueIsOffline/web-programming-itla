<?php

namespace App\Controllers;

use App\Repositories\PacientsRepository;
use JosueIsOffline\Framework\Controllers\AbstractController;
use JosueIsOffline\Framework\Http\Response;

class PacientControllers extends AbstractController
{

  public function list(): Response
  {
    $repo = new PacientsRepository();

    $patients = $repo->getAll();

    return $this->render('listo.html.twig', [
      'patients' => $patients
    ]);
  }

  public function create(): Response
  {
    return $this->render('new_visit.html.twig');
  }

  public function store(): Response
  {

    $repo = new PacientsRepository();
    var_dump($this->request->getAllPost());
    $patient = $repo->mapArrayToPacient($this->request->getAllPost());

    $repo->add($patient);

    return $this->render('new_visit.html.twig', [
      'message' => "Visita creada exitosamente!"
    ]);
  }
}
