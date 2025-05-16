<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php"); 
$response           = array();
$response["status"] = "error";
$datos1              = array();
 // $log = new KLogger ( "ajax_InsertNuevoHorario.log" , KLogger::DEBUG );
 // $log->LogInfo("Valor de la variable _POST " . var_export ($_POST, true));
//
$EntradaHorario = $_POST["entradaHorario"];
$SalidaHorario  = $_POST["salidaHorario"];
$JornadaHorario  = $_POST["JornadaHorario"];
$bandera="0";

try {
    // se realiza la consulta para ver si los valores se repiten en caso de que si se bloquea y manda un mensaje en caso contrario se realiza el insert
    if(!empty($_POST)){
        $sql1 = "SELECT * from Catalogo_Horarios";     
        $res1 = mysqli_query($conexion, $sql1);
        while (($reg1 = mysqli_fetch_array($res1, MYSQLI_ASSOC))){
            $datos1[] = $reg1;
        }
        for($i = 0; $i < count($datos1); $i++){
            $HoraEntrada     = $datos1[$i]["HoraEntrada"]; 
            $Horasalida     = $datos1[$i]["Horasalida"]; 
            $idJornada     = $datos1[$i]["idJornada"]; 
            if($HoraEntrada == $EntradaHorario && $Horasalida == $SalidaHorario && $idJornada == $JornadaHorario ){ 
                $bandera="1";
            } 
        }          
        if($bandera=="0"){
            $sql = "INSERT INTO Catalogo_Horarios (idHorarios, idJornada, HoraEntrada, Horasalida) VALUES (null,'$JornadaHorario','$EntradaHorario','$SalidaHorario')";
            $res = mysqli_query($conexion, $sql);  
            if ($res !== true) {
                $response["status"] = "error";
                $response["message"]='error al registrar el nuevo horario';
                return;
            }else{
                $response["status"]= "success";
                $response["message"]='El Horario Se Registró Correctamente';
            }
        }else{
            $response["status"] = "error";
            $response["message"]='El horario que intenta registar ya existe porfavor verifique los horarios existentes';
        }
    }
    
}catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
