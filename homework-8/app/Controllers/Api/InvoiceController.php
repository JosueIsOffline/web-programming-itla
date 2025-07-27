<?php

namespace App\Controllers\Api;

use App\Repositories\InvoiceRepository;
use App\Services\InvoiceService;
use JosueIsOffline\Framework\Controllers\AbstractController;
use JosueIsOffline\Framework\Http\Response;

class InvoiceController extends AbstractController
{

  public function store(): Response
  {
    $repo = new InvoiceRepository();

    $numero_recibo = InvoiceService::generateNumberInvoice($repo->getWithLastCode());
    $params = $this->request->getAllPost();

    $newInvoice = [
      'numero_recibo' => $numero_recibo,
      'cliente_id' => $params['id'],
      'fecha' => $params['fecha'],
      'subtotal' => $params['totalGeneral'],
      'total' => $params['totalGeneral'],
      'comentario' => $params['comentario'],
    ];

    $repo->addInvoice($newInvoice);
    $repo->addInvoiceDetail($params['articulos']);

    return $this->success([], "Recibo creado exitosamente!", 200, '/new-invoice');
  }
}
