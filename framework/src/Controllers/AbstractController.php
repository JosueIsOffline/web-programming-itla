<?php

namespace JosueIsOffline\Framework\Controllers;

use JosueIsOffline\Framework\Http\Request;
use JosueIsOffline\Framework\Http\Response;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class AbstractController
{
  protected ?Request $request = null;

  public function render(string $template, ?array $data = []): Response
  {
    $templatePath = BASE_PATH . '/views';
    $loader = new FilesystemLoader($templatePath);
    $twig = new Environment($loader);

    $content = $twig->render($template, $data);

    $response = new Response($content);

    return $response;
  }

  public function setRequest(Request $request): void
  {
    $this->request = $request;
  }
}
