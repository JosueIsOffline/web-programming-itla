<?php

namespace App\Controllers\Web;

use App\Repositories\InvoiceRepository;
use App\Repositories\ProductRepository;
use App\Services\InvoiceService;
use JosueIsOffline\Framework\Controllers\AbstractController;
use JosueIsOffline\Framework\Http\Response;

class InvoiceController extends AbstractController
{
  public function index(): Response
  {
    return $this->render("dashboard.html.twig");
  }


  public function create(): Response
  {
    $repoP = new ProductRepository();
    $repoI = new InvoiceRepository();

    $invoiceCode = $repoI->getWithLastCode();

    $products = $repoP->getAll();
    return $this->renderWithFlash("new_invoice.html.twig", [
      'articulos' => $products,
      'siguiente_numero' => InvoiceService::generateNumberInvoice($invoiceCode)
    ]);
  }
}
