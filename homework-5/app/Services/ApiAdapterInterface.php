<?php

namespace App\Services;

interface ApiAdapterInterface
{
  /**
   * Obtiene los datos procesados desde la API externa.
   * @param array $params Parámetros necesarios para la consulta (por ejemplo: ['name' => 'irma'])
   * @return array Datos ya normalizados y listos para la vista
   */
  public function fetch(array $params): array;
}
