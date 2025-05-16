<?php
session_start();
require "../conexion.php"; 
require_once("../../libs/logger/KLogger.php");
$response           = array();
$response["status"] = "error";
$datos              = array(); 
//$log = new KLogger ( "ajax_ConsultarCatalogoHorariosPorPlantilla.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable _POST " . var_export ($_POST, true));
//$log->LogInfo("Valor de la variable response " . var_export ($response, true));
$idPlantilla = $_POST["idPlantilla"];
try {
    $sql = "SELECT cj.idJornada,cj.DescripcionJornada as Jornada,ch.idHorarios,ch.HoraEntrada,ch.Horasalida
            from  Horarios_Plantillas hp
            left join Catalogo_Horarios ch on (hp.idHorario=ch.idHorarios)
            left join Catalogo_Jornadas cj on (ch.idJornada=cj.idJornada)
            where hp.idPlantilla='$idPlantilla'";     
    
        $res = mysqli_query($conexion, $sql);
        while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
        }
    
    $response["status"]= "success";
    $response["datos"] = $datos;
}catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
