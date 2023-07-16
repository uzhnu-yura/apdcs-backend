<?php
require_once 'IProcedure.php';

class BloodTypeTestrocedure implements IProcedure
{
    public function PerformProcedure($patientId, $procedureId, $connection)
    {
        $bloodType = rand(1, 4);

        $query = "INSERT IGNORE INTO patientbloodtype (PatientId, BloodType)
          SELECT '$patientId', '$bloodType'
          FROM dual
          WHERE NOT EXISTS (
              SELECT * FROM patientbloodtype WHERE PatientId = '$patientId'
          )";

        $connection->query($query);

        if ($connection->affected_rows > 0 === TRUE) {
            $measurementDate = date("Y-m-d");
            $query = "INSERT INTO patientprocedures (PatientId, ProcedureId, ProcedureDate)
                                  VALUES ('$patientId', '$procedureId', '$measurementDate')";
            $connection->query($query);
            return true;
        } else  return false;
    }
}
