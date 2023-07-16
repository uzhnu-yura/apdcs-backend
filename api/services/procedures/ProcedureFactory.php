<?php

require_once 'BloodSugarTestProcedure.php';
require_once 'BloodTypeTestrocedure.php';
require_once 'BodyMetricsProcedure.php';

class ProcedureFactory
{
    public static function createProcedure($procedureName)
    {
        switch ($procedureName) {
            case "Body metrics":
                return new BodyMetricsProcedure();
            case "Blood Sugar Test":
                return new BloodSugarTestProcedure();
            case "Blood Type Test":
                return new BloodTypeTestrocedure();
            default:
                die('Invalid procedure name');
        }
    }
}
