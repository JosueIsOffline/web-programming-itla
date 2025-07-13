<?php

namespace App\Controllers;

use App\Repositories\ViewRepository;
use JosueIsOffline\Framework\Controllers\AbstractController;
use JosueIsOffline\Framework\Http\Response;

class ViewController extends AbstractController
{

  public function index(): Response
  {
    return $this->render('index.html.twig');
  }

  public function list(): Response
  {
    $repo = new ViewRepository();

    $views = $repo->getAll();
    return $this->render('list.html.twig', [
      'visitas' => $views
    ]);
  }

  public function create(): Response
  {
    return $this->render('registro.html.twig');
  }

  public function store(): Response
  {
    $params = $this->request->getAllPost();
    $repo = new ViewRepository();
    $repo->add($params);

    return $this->render('registro.html.twig');
  }

  public function edit(int $id): Response
  {
    $repo = new ViewRepository();
    $view = $repo->getById($id);

    if ($this->request->getMethod() === "POST") {
      $params = $this->request->getAllPost();
      $view = $repo->edit($params);
      $views = $repo->getAll();

      $this->list();
    }

    return $this->render("registro.html.twig", [
      "datos" => $view,
      "action" => "edit"
    ]);
  }

  public function delete(int $id): Response
  {
    $repo = new ViewRepository();
    $repo->delete($id);

    return $this->render("list.html.twig");
  }
}
