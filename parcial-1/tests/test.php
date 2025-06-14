<?php
define("BASE_PATH", dirname(__DIR__));
require_once(BASE_PATH . '/vendor/autoload.php');

use App\Models\Patient;
use App\Repositories\PatientRepository;

// $patient = new Patient();
// $patient->__set('nombre', 'Josue');

$repo = new PatientRepository();

$patient = new Patient();
$patient->nombre = 'Angela';
$patient->apellido = 'Parra';
$patient->cedula = '001-23867564-2';
$patient->edad = 20;
$patient->motivo = 'Ortodoncia';

var_dump($patient->motivo);

// $date =  \DateTime::createFromFormat('Y-m-d H:i:s', '2025-06-23 13:00:00');
// $pantient->fechaHora = $date;
/* var_dump($date); */

// $repo->add($patient);
$patients = $repo->getAll();

/* var_dump($patients); */
