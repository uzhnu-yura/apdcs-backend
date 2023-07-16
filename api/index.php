<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Origin, Content-Type, Accept");

require 'vendor/autoload.php';

$app = new \Slim\App();

$routes = [
    'controllers/MedicalIndicatorsController.php',
    'controllers/PatientsController.php',
    'controllers/ProceduresController.php',
];

foreach ($routes as $routeFile) {
    $route = require $routeFile;
    $route($app);
}

$app->run();