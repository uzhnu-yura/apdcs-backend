<?php
require_once 'IProcedure.php';

class BloodSugarTestProcedure implements IProcedure
{
    public function PerformProcedure($patientId, $procedureId, $connection)
    {
        $measurementDate = date("Y-m-d");
        $sugarLevel = round(mt_rand(26, 84) / 10, 1);

        $query = "SELECT SugarLevel FROM patientsugarlevel WHERE PatientId = '$patientId'";
        $sqlPrevBloodPressure = mysqli_query($connection, $query);
        $prevBloodPressureRow = mysqli_fetch_assoc($sqlPrevBloodPressure);
        if ($prevBloodPressureRow != null)
            $prevBloodPressure = reset($prevBloodPressureRow);
        else $prevBloodPressure = null;

        $query = "INSERT INTO patientsugarlevel (PatientId, PrevSugarLevel, SugarLevel, MeasurementDate)
                        VALUES ('$patientId', '$prevBloodPressure', '$sugarLevel', '$measurementDate')
                        ON DUPLICATE KEY UPDATE
                        PrevSugarLevel = '$prevBloodPressure',
                        SugarLevel = '$sugarLevel',
                        MeasurementDate = '$measurementDate';";

        if ($connection->query($query) === TRUE) {
            $query = "INSERT INTO patientprocedures (PatientId, ProcedureId, ProcedureDate)
                                      VALUES ('$patientId', '$procedureId', '$measurementDate')";
            $connection->query($query);
            return true;
        } else  return false;
    }
}
