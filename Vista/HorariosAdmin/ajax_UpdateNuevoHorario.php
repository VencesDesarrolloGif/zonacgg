<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response           = array(); 
$response["status"] = "error"; 
$datos1              = array();
  // $log = new KLogger ( "ajax_UpdateNuevoHorario.log" , KLogger::DEBUG );
  // $log->LogInfo("Valor de la variable _POST " . var_export ($_POST, true));
// Este ajax se utiliza en el modulo de ventas en el formulario de form_ConsultaPuntosServicios en la funcion ActualizarHorario
$idPlantilla = $_POST["idPlantilla"];
$inIdHorarioEdit  = $_POST["inIdHorarioEdit"];

try {
    // se realiza la consulta para ver si los valores se repiten en caso de que si se bloquea y manda un mensaje en caso contrario se realiza el insert
    if(!empty($_POST)){
        
        $sql = "INSERT INTO Horarios_Plantillas (idHorarioPlantillas, idPlantilla, idHorario) VALUES (null, '$idPlantilla', '$inIdHorarioEdit')";
        $res = mysqli_query($conexion, $sql);  
        if ($res !== true) {
            $response["status"] = "error";
            $response["message"]='error al ingresar el nuevo horario';
            return;
        }else{
            $response["status"]= "success";
            $response["message"]='El Horario Se Agregó Correctamente';
        }
        
    }
}catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
