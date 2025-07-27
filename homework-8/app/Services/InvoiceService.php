<?php

namespace App\Services;

class InvoiceService
{

  public static function generateNumberInvoice(array $data): string
  {
    $number = explode('-', $data['numero_recibo'])[1];

    $number += 1;

    $createNewNumber = "REC-" . str_pad($number, 3, "0", STR_PAD_LEFT);

    return $createNewNumber;
  }
}
