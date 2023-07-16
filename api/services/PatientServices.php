<?php

class PatientsServices
{
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }


    public function CreatePatient($firstname, $lastname, $dob, $phone)
    {
        $query = "INSERT INTO `patients` (`firstname`, `lastname`, `dateOfBirth`, `isArchived`) VALUES (?, ?, ?, ?)";
        $statement = mysqli_prepare($this->connection, $query);

        $isArchived = false;
        mysqli_stmt_bind_param(
            $statement,
            "ssss", // s - string
            $firstname,
            $lastname,
            $dob,
            $isArchived
        );

        $success = mysqli_stmt_execute($statement);
        $insertedId = mysqli_stmt_insert_id($statement);

        $query = "INSERT INTO `patientphone` (`patientId`, `phone`) VALUES ('$insertedId', '$phone')";
        $success = $this->connection->query($query);

        mysqli_stmt_close($statement);
        return $success;
    }


    public function ArchivePatient($id)
    {
        $query = "UPDATE `patients` SET `isArchived` = true WHERE `id` = '$id'";
        $statement = mysqli_prepare($this->connection, $query);

        $success = mysqli_stmt_execute($statement);
        mysqli_stmt_close($statement);
        return $success;
    }

    public function EditPatient($id, $firstname, $lastname, $dob, $phone)
    {
        $query = "UPDATE `patients` 
        INNER JOIN patientphone ON patients.Id = patientphone.PatientId
        SET `patients.Firstname` = ?, `patients.Lastname` = ?, `patients.DateOfBirth` = ? 
        `patientphone.phone` = ?
        WHERE `Id` = ?";

        $query = "UPDATE `patients`
        INNER JOIN `patientphone` ON `patients`.`Id` = `patientphone`.`PatientId`
        SET `patients`.`Firstname` = ?, `patients`.`Lastname` = ?, `patients`.`DateOfBirth` = ?,
        `patientphone`.`phone` = ?
        WHERE `patients`.`Id` = ?";


        $statement = mysqli_prepare($this->connection, $query);

        mysqli_stmt_bind_param($statement, 'ssssi', $firstname, $lastname, $dob, $phone, $id);

        $success = mysqli_stmt_execute($statement);

        mysqli_stmt_close($statement);

        return $success;
    }


    public function GetPatients()
    {
        $sqldata = mysqli_query($this->connection, "SELECT firstname, lastname, dateOfBirth FROM `patients`
        WHERE isArchieved = false");
        $patients = [];

        while ($patient = mysqli_fetch_assoc($sqldata)) {
            $patients[] = $patient;
        }

        return json_encode($patients);
    }


    public function GetPatientWithPhone()
    {
        $sqldata = mysqli_query($this->connection, "SELECT patients.*, patientphone.Phone
        FROM patients
        JOIN patientphone
        ON patients.id = patientphone.patientId
        WHERE isArchived = false");
        $patients = [];

        while ($patient = mysqli_fetch_assoc($sqldata)) {
            $patients[] = $patient;
        }
        return json_encode($patients);
    }


    public function GetQuestionnaireById($index)
    {
        $sqldata = mysqli_query($this->connection, "SELECT * FROM `patients` WHERE `id` = '$index'");
        $patient = mysqli_fetch_assoc($sqldata);
        return json_encode($patient);
    }
}
