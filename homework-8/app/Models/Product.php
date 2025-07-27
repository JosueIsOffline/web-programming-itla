<?php

namespace App\Models;

use JosueIsOffline\Framework\Model\Model;

class Product extends Model
{
  public array $fillabel = ['nombre', 'precio_unitario', 'stock', 'activo', 'created_at'];
}
