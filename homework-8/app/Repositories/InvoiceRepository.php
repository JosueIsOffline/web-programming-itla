<?php

namespace App\Repositories;

use App\Models\Invoice;
use App\Models\Invoice_Detail;

class InvoiceRepository
{

  public function getAll(): array
  {
    return Invoice::all();
  }

  public function getWithLastCode(): array
  {
    $data = $this->getAll();
    $lastOne =  count($data);

    return $data[$lastOne - 1];
  }

  public function addInvoice(array $data): void
  {
    $invoice = new Invoice();
    $invoice->create($data);
  }

  public function addInvoiceDetail(array $data): void
  {
    $invoiceDetail = new Invoice_Detail();
    $invoices = $this->getAll();
    $id = count($invoices);
    foreach ($data as $articulo) {
      $dataAdapter = [
        'factura_id' => $id,
        'articulo_id' => $articulo['id'],
        'cantidad' => $articulo['cantidad'],
        'precio_unitario' => $articulo['precio'],
        'total' => $articulo['total']
      ];
      $invoiceDetail->create($dataAdapter);
    }
  }
}
