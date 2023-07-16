<?php

require 'dbconnect.php';

require_once 'services/PatientServices.php';
$patientsServices = new PatientsServices($connection);


return function ($app) use (
    $patientsServices,
) {
    $app->get('/archive/{id}', function ($request, $response, $args) use ($patientsServices) {
        $success = $patientsServices->ArchivePatient($args['id']);

        if ($success)
            return $response->withJson(['message' => "Ok"], 200);
        else
            return $response->withJson(['error' => "Error while archiving patient"], 500);
    });

    $app->put('/patient', function ($request, $response) use ($patientsServices) {
        $data = $request->getParsedBody();
        $patientId = $data['id'];
        $firstname = $data['firstname'];
        $lastname = $data['lastname'];
        $dob = $data['dob'];
        $phone = $data['phone'];
        $success = $patientsServices->EditPatient($patientId, $firstname, $lastname, $dob, $phone);

        if ($success)
            return $response->withJson(['message' => "Ok"], 200);
        else
            return $response->withJson(['error' => "Error while editing patient"], 500);
    });

    $app->post('/patient', function ($request, $response) use ($patientsServices) {
        $data = $request->getParsedBody();

        $firstname = $data['firstname'];
        $lastname = $data['lastname'];
        $dob = $data['dob'];
        $phone = $data['phone'];

        $result = $patientsServices->CreatePatient($firstname, $lastname, $dob, $phone);

        if ($result)
            return $response->withJson(['message' => 'Patient created successfully'], 200);
        else
            return $response->withJson(['error' => 'Failed to create patient'], 500);
    });

    $app->get('/patients', function () use ($patientsServices) {
        return $patientsServices->GetPatients();
    });


    $app->get('/patientsphone', function () use ($patientsServices) {
        return $patientsServices->GetPatientWithPhone();
    });
};
