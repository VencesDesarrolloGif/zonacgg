<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php"); 
$response           = array();
$response["status"] = "error";
$datos1              = array();
 // $log = new KLogger ( "ajax_InsertNuevaJornada.log" , KLogger::DEBUG );
 // $log->LogInfo("Valor de la variable _POST " . var_export ($_POST, true));
//
$NuevaJornada1 = $_POST["NuevaJornada"];
$NuevaJornada = strtoupper($NuevaJornada1);
$bandera="0";

try {
    // se realiza la consulta para ver si los valores se repiten en caso de que si se bloquea y manda un mensaje en caso contrario se realiza el insert
    if(!empty($_POST)){
        $sql = "INSERT INTO Catalogo_Jornadas (idJornada, DescripcionJornada) VALUES (null,'$NuevaJornada')";
        $res = mysqli_query($conexion, $sql);  
        if ($res !== true) {
            $response["status"] = "error";
            $response["message"]='error al registrar el nuevo horario';
            return;
        }else{
            $response["status"]= "success";
            $response["message"]='El Horario Se Registró Correctamente';
        }
    }
    
}catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
