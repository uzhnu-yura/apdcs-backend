<?php

class ProcedureServices
{
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function GetProcedures()
    {
        $sqlprocedures = mysqli_query($this->connection, "SELECT * FROM `procedures`");
        $procedures = [];

        while($procedure = mysqli_fetch_assoc($sqlprocedures)){
            $procedures[] = $procedure;
        }
        echo json_encode($procedures);
    }

    public function GetProcedureById($index)
    {
        $sqlprocedure = mysqli_query($this->connection, "SELECT * FROM `procedures` WHERE `id` = '$index'");
        $procedure = mysqli_fetch_assoc($sqlprocedure);
        echo json_encode($procedure);
    }

   
}
