<?php

namespace App\Models;

use JosueIsOffline\Framework\Models\Model;

class Book extends Model
{
  protected string $table = 'books';
  protected array $fillable = ['title', 'body', 'author', 'published_at'];
}
