<?php

class MedicalIndicatorsServices
{
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function GetAllMedicalIndicatorsForPatient($patientId)
    {
        $query = "SELECT patientmetrics.Weight, patientmetrics.Height, patientbloodtype.BloodType, patientsugarlevel.PrevSugarLevel, patientsugarlevel.SugarLevel
        FROM patients
        LEFT JOIN patientmetrics ON patients.Id = patientmetrics.PatientId
        LEFT JOIN patientbloodtype ON patients.Id = patientbloodtype.PatientId
        LEFT JOIN patientsugarlevel ON patients.Id = patientsugarlevel.PatientId
        WHERE patients.Id = '$patientId';";
        $sqldata = mysqli_query($this->connection, $query);
        $medicalIndicators = mysqli_fetch_assoc($sqldata);

        return json_encode($medicalIndicators);
    }
}
