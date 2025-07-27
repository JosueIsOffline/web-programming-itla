<?php

namespace App\Models;

use JosueIsOffline\Framework\Model\Model;

class Invoice_Detail extends Model
{
  public array $fillabel = ['factura_id', 'articulo_id', 'cantidad', 'precio_unitario', 'total'];
}
