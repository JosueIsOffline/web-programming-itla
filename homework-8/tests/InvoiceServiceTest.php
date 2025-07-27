<?php

use App\Services\InvoiceService;
use PHPUnit\Framework\TestCase;

class InvoiceServiceTest extends TestCase
{
  public function testGenerateNumberInvoice()
  {
    $service = new InvoiceService();
    $data = [
      'numero_recibo' => 'REC-012'
    ];

    $number = $service->generateNumberInvoice($data);

    $this->expectOutputString("REC-013");

    print($number);
  }
}
