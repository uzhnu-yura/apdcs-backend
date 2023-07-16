<?php

require 'dbconnect.php';

require_once 'services/ProcedureServices.php';
require_once 'services/procedures/ProcedureFactory.php';
$procedureServices = new ProcedureServices($connection);
$procedureFactory = new ProcedureFactory();


return function ($app) use (
    $procedureServices,
    $procedureFactory,
    $connection,
) {

    $app->get('/procedures', function () use ($procedureServices) {
        $procedureServices->GetProcedures();
    });
    
    
    $app->post('/performprocedure', function ($request, $response) use ($procedureFactory, $connection) {
        $data = $request->getParsedBody();
        $patientId = $data['patientId'];
        $procedureName = $data['procedureName'];
        $procedureId = $data['procedureId'];
        $procedure =  $procedureFactory->createProcedure($procedureName);
        $result = $procedure->PerformProcedure($patientId, $procedureId, $connection);
    
        if (true) { //change later
            return $response->withJson(['message' => $result], 200);
        } else {
            return $response->withJson(['error' => $result], 500);
        }
    });
    
    
    $app->get('/procedure/{id}', function ($request, $response, $args) use ($procedureServices) {
        $procedureServices->GetProcedureById($args['id']);
    });
    
};


