<?php

use JosueIsOffline\Framework\Http\Kernel;
use JosueIsOffline\Framework\Http\Request;
use JosueIsOffline\Framework\Http\Response;

define("BASE_PATH", dirname(__DIR__));

require_once BASE_PATH . "/vendor/autoload.php";

$request = Request::create();

$kernel = new Kernel();
$response = $kernel->handle($request);
$response->send();
