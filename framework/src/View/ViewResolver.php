<?php

namespace JosueIsOffline\Framework\View;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class ViewResolver
{
  private Environment $twig;
  private array $viewPaths = [];
  private string $baseViewPath;

  public function __construct(?string $baseViewPath = null)
  {
    $this->baseViewPath = $baseViewPath ?? BASE_PATH . '/views';
    $this->setupTwig();
  }

  private function setupTwig(): void
  {
    $this->scanViewDirectories();

    $loader = new FilesystemLoader($this->viewPaths);
    $this->twig = new Environment($loader, [
      'cache' => false,
      'debug' => true
    ]);
  }

  private function scanViewDirectories(): void
  {
    if (!is_dir($this->baseViewPath)) {
      throw new \RuntimeException("The directory of view doesn't exits: {$this->baseViewPath}");
    }

    $this->viewPaths[] = $this->baseViewPath;

    $directories = glob($this->baseViewPath . '/*', GLOB_ONLYDIR);

    foreach ($directories as $directory) {
      $this->viewPaths[] = $directory;

      $this->scanNestedDirectories($directory);
    }
  }

  private function scanNestedDirectories(string $directory): void
  {
    $nestedDirs = glob($directory . '/*', GLOB_ONLYDIR);

    foreach ($nestedDirs as $nestedDir) {
      $this->viewPaths[] = $nestedDir;
      $this->scanNestedDirectories($nestedDir);
    }
  }

  public function render(string $template, array $data = []): string
  {
    try {
      return $this->twig->render($template, $data);
    } catch (\Twig\Error\LoaderError $e) {
      throw new \RuntimeException("View not found: {$template}. Routes availables: " . implode(', ', $this->viewPaths));
    }
  }

  public function addViewPath(string $path): void
  {
    if (is_dir($path)) {
      $this->viewPaths[] = $path;
      $this->setupTwig();
    }
  }

  public function addViewPaths(array $paths): void
  {
    foreach ($paths as $path) {
      $this->addViewPath($path);
    }
  }

  public function getViewPaths(): array
  {
    return $this->viewPaths;
  }

  public function viewExists(string $template): bool
  {
    try {
      $this->twig->getLoader()->getSourceContext($template);
      return true;
    } catch (\Twig\Error\LoaderError $e) {
      return false;
    }
  }
}
