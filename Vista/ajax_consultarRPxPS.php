<?php
    session_start();
    require "conexion.php"; 
    require_once("../libs/logger/KLogger.php");
    // $log = new KLogger ( "ajax_consultarRPxPS.log" , KLogger::DEBUG );
    // $log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));  
    $response = array("status" => "success");
    $puntoServicio=$_POST["puntoServicio"];
    $datos = array();

    try{

        $sql = "SELECT s.IdRegistroPatronal
                FROM catalogopuntosservicios cps
                LEFT JOIN asentamientos asent ON asent.municipioAsentamiento=cps.MunicipioPuntoS
                LEFT JOIN sucursal s ON s.IdSuc=asent.idRegPatAsignado
                WHERE cps.idPuntoServicio='$puntoServicio'
                LIMIT 1";      

    // $log->LogInfo("Valor de la variable sql: " . var_export ($sql, true));  
        $res = mysqli_query($conexion, $sql);
        while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
        }
    $response["datos"] = $datos;
    } 
    catch( Exception $e )
    {
        $response["status"]="error";
        $response["message"]="No se obtubo los puestos por departamento";
    }
    echo json_encode($response);
?>