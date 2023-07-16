<?php

require 'dbconnect.php';

require_once 'services/MedicalIndicatorsServices.php';
$medicalIndicatorsServices = new MedicalIndicatorsServices($connection);

return function ($app) use (
    $medicalIndicatorsServices,
) {
    $app->get('/medicalIndicators/{index}', function ($request, $response, $args) use ($medicalIndicatorsServices) {
        $patientId = $args['index'];
        return $medicalIndicatorsServices->GetAllMedicalIndicatorsForPatient($patientId);
    });
 
};

