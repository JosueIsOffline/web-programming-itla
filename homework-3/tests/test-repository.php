<?php
define("BASE_PATH", dirname(__DIR__));

require_once(BASE_PATH . '/vendor/autoload.php');

use App\Models\Personaje;
use App\Models\Profesion;
use App\Repositories\InMemoryPersonajeRepository;
use App\Repositories\ProfesionesRepository;

// Crear instancia del repositorio
$repo = new InMemoryPersonajeRepository();
$repo2 = new ProfesionesRepository();

// Probar getAll
// $all = $repo->getAll();
// echo "Todos los personajes:\n";
// var_dump($all);
//
// Probar findById
// $idToFind = 1;
// $personaje = $repo->findById($idToFind);
// echo "Personaje con ID $idToFind:\n";
// var_dump($personaje);

// Probar add
// $nuevoPersonaje = new Personaje();
// $nuevoPersonaje->setName("Nuevo");
// $nuevoPersonaje->setLastName("Personaje");
// $nuevoPersonaje->setBornDate(new DateTime('2000-01-01'));
// $nuevoPersonaje->setLevelExperience("Junior");
// $nuevoPersonaje->setPhoto("foto");
// $result = $repo2->getAll();
// $prof = [$result[0]];
//
// $nuevoPersonaje->setProfessions($prof);
// $repo->add($nuevoPersonaje);
// echo "Agregado nuevo personaje.\n";

// Probar update
// $updatePersonaje = $repo->findById(2);
// $updatePersonaje->setName("Bruce");
// $updatePersonaje->setLastName("Wayne");
// $repo->update($updatePersonaje);
// echo "Actualizado personaje. \n";

// Probar delete
// $repo->delete(2);
// echo "Eliminado \n";
//
// // Volver a obtener todos para verificar el agregado
// $allAfterAdd = $repo->getAll();
// echo "Personajes después de agregar:\n";
// var_dump($allAfterAdd);
//
$profesion = new Profesion();
$profesion->setName("Test 2");
$profesion->setCategory("Test 2");
$profesion->setSalary(30000.00);
$repo2->add($profesion);
$repo2->getAll();
