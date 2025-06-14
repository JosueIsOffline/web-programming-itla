<?php
define("BASE_PATH", dirname(__DIR__));

require_once(BASE_PATH . '/vendor/autoload.php');

use App\Data\JsonFileHandler;
use App\Models\Pacient;
use App\Repositories\PacientsRepository;

$filePath = __DIR__ . '/../data/pacientes.json';

// $jsonHandler = JsonFileHandler::getInstance($filePath);
// $data = $jsonHandler->getData();

/* var_dump($data); */

$repo = new PacientsRepository();



$p = new Pacient();
$p->setName("Angela");
$p->setLastName("Parra");
$p->setCedula("001-02938332-5");
$p->setAge(20);
$p->setReason("Carie");
$p->setDateH(new \DateTime('2025-06-27 14:00'));

$repo->add($p);


$result = $repo->getAll();

var_dump($result);
