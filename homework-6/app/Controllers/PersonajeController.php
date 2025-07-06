<?php

namespace App\Controllers;

use App\Repositories\PersonajeRepository;
use JosueIsOffline\Framework\Controllers\AbstractController;
use JosueIsOffline\Framework\Http\Response;

class PersonajeController extends AbstractController
{

  public function index(): Response
  {
    $repo = new PersonajeRepository();

    $personaje = $repo->getAll();
    return $this->render("index.html.twig", [
      'personajes' => $personaje
    ]);
  }

  public function create(): Response
  {
    return $this->render('form.html.twig');
  }

  public function store(): Response
  {
    $params = $this->request->getAllPost();
    $repo = new PersonajeRepository();
    $repo->add($params);

    return $this->index();
  }

  public function update(int $id): Response
  {
    $repo = new PersonajeRepository();
    $pj = $repo->getById($id);

    if ($this->request->getMethod() === "POST") {
      $params = $this->request->getAllpost();
      $pj = $repo->update($params);

      return $this->index();
    }

    return $this->render('form.html.twig', [
      'personaje' => $pj,
      'action' => 'edit'
    ]);
  }

  public function delete(int $id): Response
  {
    $repo = new PersonajeRepository();
    $repo->delete($id);

    return $this->render('index.html.twig', [
      'personajes' => $repo->getAll()
    ]);
  }
}
