<?php

namespace App\Models;

use DateTime;
use JsonSerializable;

class Personaje implements JsonSerializable
{
  private ?int  $id;
  private string $nombre;
  private string $apellido;
  private DateTime $fechaNacimiento;
  private ?string $foto;
  private array $profesiones;
  private string $nivelExperiencia;

  public function __construct()
  {
    $this->fechaNacimiento = new DateTime();
  }

  public function jsonSerialize(): array
  {
    return [
      'id' => $this->id,
      'nombre' => $this->nombre,
      'apellido' => $this->apellido,
      'fechaNacimiento' => $this->fechaNacimiento->format('Y-m-d'),
      'foto' => $this->foto,
      'profesiones' => array_map(fn($prof) => $prof->jsonSerialize(), $this->profesiones),
      'nivelExperiencia' => $this->nivelExperiencia,
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

  public function getBornDate(): DateTime
  {
    return $this->fechaNacimiento;
  }

  public function setBornDate(DateTime $bornDate): void
  {
    $this->fechaNacimiento = $bornDate;
  }

  public function getPhoto(): string
  {
    return $this->foto;
  }

  public function setPhoto(string $photo): void
  {
    $this->foto = $photo;
  }

  public function getProfessions(): array
  {
    return $this->profesiones;
  }

  public function setProfessions(array $professions): void
  {
    $this->profesiones = $professions;
  }

  public function getLevelExperience(): int
  {
    return $this->nivelExperiencia;
  }

  public function setLevelExperience(string $levlExperience): void
  {
    $this->nivelExperiencia = $levlExperience;
  }
}
