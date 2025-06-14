<?php

namespace App\Repositories;

use App\Data\JsonFileHandler;
use App\Models\Pacient;
use App\Repositories\BaseRepository;

class PacientsRepository extends BaseRepository
{

  private const DATA_PATH = __DIR__ . '/../../data/pacientes.json';

  public function getAll(): array
  {
    $pacients = [];
    $conn = JsonFileHandler::getInstance(self::DATA_PATH);
    $conn->reload();
    $data = $conn->getData();

    $pacients = $this->mapListPacients($data);

    return $pacients;
  }

  public function getById(int $id): ?Pacient
  {
    $patient = null;
    return $patient;
  }

  public function add(Pacient $p): void
  {
    $patients = $this->getAll();
    $maxId = 0;

    foreach ($patients as $patient) {
      if ($patient->getId() > $maxId) {
        $maxId = $patient->getId();
      }
    }
    $newId = $maxId + 1;

    $p->setId($newId);
    $patients[] = $p;

    $conn = JsonFileHandler::getInstance(self::DATA_PATH);
    $conn->setData($patients);
    $conn->save();
  }

  public function edit(Pacient $p): void {}

  public function delete(int $id): void {}



  public function mapArrayToPacient(array $p): ?Pacient
  {
    $pacient = new Pacient();

    if (isset($p["id"])) {
      $pacient->setId($p['id']);
    }

    $pacient->setName($p['nombre']);
    $pacient->setLastName($p['apellido']);
    $pacient->setCedula($p['cedula']);
    $pacient->setAge($p['edad']);
    $pacient->setReason($p['motivo']);


    $fechaHora = \DateTime::createFromFormat('Y-m-d H:i:s', $p['fechaHora']);
    if ($fechaHora === false) {
      $error = \DateTime::getLastErrors();
      var_dump($error);

      return null;
    }
    $pacient->setDateH($fechaHora);

    return $pacient;
  }


  private function mapListPacients(array $list): array
  {
    $pacients = [];

    foreach ($list as $p) {
      $pacient = $this->mapArrayToPacient($p);
      if ($pacient !== null) {
        $pacients[] = $pacient;
      }
    }

    return $pacients;
  }
}
