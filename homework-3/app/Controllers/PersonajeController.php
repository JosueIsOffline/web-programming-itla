<?php

namespace App\Controllers;

use App\Repositories\InMemoryPersonajeRepository;
use JosueIsOffline\Framework\Controllers\AbstractController;
use JosueIsOffline\Framework\Http\Response;

class PersonajeController extends AbstractController
{
  public function index(): Response
  {
    return $this->render("index.html.twig");
  }

  public function dashboard(): Response
  {
    $repo = new InMemoryPersonajeRepository();
    $personajes = $repo->getAll();

    return $this->render('dashboard.html.twig', [
      "personajes" => $personajes
    ]);
  }

  public function list(): Response
  {
    $repo = new InMemoryPersonajeRepository();
    $personajes = $repo->getAll();

    return $this->render("list.html.twig", ['personajes' => $personajes]);
  }

  public function create(): Response
  {
    return $this->render("create.html.twig");
  }

  public function store(): Response
  {
    $repo = new InMemoryPersonajeRepository();
    $personaje = $repo->mapArrayToPersonaje($this->request->getAllPost());
    $repo->add($personaje);

    return $this->render('create.html.twig', [
      'message' => 'Personaje creado exitosamente!',
    ]);
  }

  public function edit(int $id): Response
  {
    $repo = new InMemoryPersonajeRepository();
    $personaje = $repo->findById($id);

    return $this->render('edit.html.twig', ["personaje" => $personaje]);
  }

  public function update(): Response
  {
    $repo = new InMemoryPersonajeRepository();

    $personaje = $repo->mapArrayToPersonaje($this->request->getAllPost());

    $repo->update($personaje);

    return $this->render('edit.html.twig', [
      'message' => 'Personaje editado con exito!'
    ]);
  }

  public function delete(int $id): Response
  {

    $repo = new InMemoryPersonajeRepository();
    $repo->delete($id);

    return $this->render("listp.html.twig", [
      "message" => "Personaje eliminado exitosamente!"
    ]);
  }
}
