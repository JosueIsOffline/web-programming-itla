<?php

namespace App\Repositories;

use App\Data\JsonFileHandler;
use App\Models\Patient;

class PatientRepository extends BaseRepository
{

  private const DATA_PATH = __DIR__ . '/../../data/patients.json';

  public function getAll(): array
  {
    $patients = [];
    $conn = JsonFileHandler::getinstace(self::DATA_PATH);
    $data = $conn->getData();


    $patients = $this->MapListToPatient($data);
    return $patients;
  }

  public function getById(int $id): ?Patient
  {
    $patients = $this->getAll();

    $patient = new Patient();
    // foreach($patients as $p){
    //   if($p === $id){
    //
    //   }
    // }
    return $patient;
  }

  public function add(Patient $p): void
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

    $conn = JsonFileHandler::getInstace(self::DATA_PATH);
    $conn->setData($patients);
    $conn->save();
  }

  public function edit(Patient $p): void {}

  public function delete(int $id): void {}


  public function mapArrayToPatient(array $p): ?Patient
  {
    $patient = new Patient();

    if (isset($p["id"])) {
      $patient->setId($p['id']);
    }

    $patient->setName($p['nombre']);
    $patient->setLastName($p['apellido']);
    $patient->setCedula($p['cedula']);
    $patient->setAge($p['edad']);
    $patient->setReason($p['motivo']);
    $fechaHora = \DateTime::createFromFormat("Y-m-d H:i:s", $p['fechaHora']);
    $patient->setDateH($fechaHora);

    return $patient;
  }

  private function MapListToPatient(array $list): array
  {
    $patients = [];

    foreach ($list as $p) {
      $patient = $this->mapArrayToPatient($p);
      if ($p != null) {
        $patients[] = $patient;
      }
    }

    return $patients;
  }
}
