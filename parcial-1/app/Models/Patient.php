<?php

namespace App\Models;

use DateTime;
use JsonSerializable;

// Creation of main model: Patient
// Create By Josue Hernandez / 2024-0235

class Patient implements JsonSerializable
{
  private ?int $id;
  private string $nombre;
  private string $apellido;
  private string $cedula;
  private int $edad;
  private string $motivo;
  private DateTime $fechaHora;

  public function __construct()
  {
    $this->fechaHora = new DateTime();
  }


  public function jsonSerialize(): array
  {
    return [
      'id' => $this->id,
      'nombre' => $this->nombre,
      'apellido' => $this->apellido,
      'cedula' => $this->cedula,
      'edad' => $this->edad,
      'motivo' => $this->motivo,
      'fechaHora' => $this->fechaHora->format('Y-m-d H:i:s'),
    ];
  }
  public function getId(): int
  {
    return $this->id;
  }

  public function setId(int $id): void
  {
    $this->id = $id;
  }

  public function getName(): string
  {
    return $this->nombre;
  }

  public function setName(string $name): void
  {
    $this->nombre = $name;
  }

  public function getLastName(): string
  {
    return $this->apellido;
  }

  public function setLastName(string $lastName): void
  {
    $this->apellido = $lastName;
  }

  public function getCedula(): string
  {
    return $this->cedula;
  }

  public function setCedula(string $cedula): void
  {
    $this->cedula = $cedula;
  }

  public function getAge(): int
  {
    return $this->edad;
  }

  public function setAge(int $age): void
  {
    $this->edad = $age;
  }

  public function getReason(): string
  {
    return $this->motivo;
  }

  public function setReason(string $reason): void
  {
    $this->motivo = $reason;
  }

  public function getDateH(): DateTime
  {
    return $this->fechaHora;
  }

  public function setDateH(DateTime $date): void
  {
    $this->fechaHora = $date;
  }
}
