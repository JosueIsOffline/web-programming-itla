<?php

namespace App\Controllers;

use App\Repositories\PatientRepository;
use JosueIsOffline\Framework\Controllers\AbstractController;
use JosueIsOffline\Framework\Http\Response;

class PatientController extends AbstractController
{
  public function index(): Response
  {
    $repo = new PatientRepository();

    $patients = $repo->getAll();

    return $this->render('index.html.twig', [
      'patients' => $patients
    ]);
  }

  public function create(): Response
  {
    return $this->render('new_visit.html.twig');
  }

  public function store(): Response
  {
    $data = $this->request->getAllPost();

    $repo = new PatientRepository();
    $patient = $repo->mapArrayToPatient($data);

    $repo->add($patient);

    return $this->render('index.html.twig', [
      "message" => "Visita creada exitosamente!"
    ]);
  }
}
