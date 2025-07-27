<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
  public function getAll(): array
  {
    $product = new Product();

    return $product->all();
  }

  public function getWithLastCode(): array
  {
    $data = $this->getAll();
    $lastOne =  count($data);

    return $data[$lastOne - 1];
  }
}
