<?php

namespace App\Models;

use JosueIsOffline\Framework\Model\Model;

class Invoice extends Model
{
  public array $fillabel = ['numero_recibo', 'client_id', 'fecha', 'subtotal', 'total', 'comentario', 'created_at'];
}
