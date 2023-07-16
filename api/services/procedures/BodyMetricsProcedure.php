<?php
require_once 'IProcedure.php';


class BodyMetricsProcedure implements IProcedure
{
    public function PerformProcedure($patientId, $procedureId, $connection)
    {
        $weight = rand(35, 100);
        $height = rand(150, 210);
        $measurementDate = date("Y-m-d");
      
        $query = "INSERT INTO patientmetrics (PatientId, Weight, Height, MeasurementDate)
                    VALUES ('$patientId', '$weight', '$height', '$measurementDate')
                    ON DUPLICATE KEY UPDATE
                        Weight = '$weight',
                        Height = '$height',
                        MeasurementDate = '$measurementDate';";

        if ($connection->query($query) === TRUE) {
            $query = "INSERT INTO patientprocedures (PatientId, ProcedureId, ProcedureDate)
                                  VALUES ('$patientId', '$procedureId', '$measurementDate')";
            $connection->query($query); 
            return true;
        } else  return false;
    }
}
