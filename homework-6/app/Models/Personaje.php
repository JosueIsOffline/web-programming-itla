<?php

namespace App\Models;

use JosueIsOffline\Framework\Model\Model;

class Personaje extends Model
{
  protected array $fillable = ['nombre', 'color', 'tipo', 'nivel', 'foto'];
}
