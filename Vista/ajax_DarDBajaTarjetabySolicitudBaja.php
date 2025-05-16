<?php
session_start ();
require_once ("../libs/logger/KLogger.php");
require "conexion.php";
//$log = new KLogger ( "ajax_DarDBajaTarjetabySolicitudBaja.log" , KLogger::DEBUG );
// $log->LogInfo("Valor de la variable post: " . var_export ($_POST, true));
$noEmpFirma = $_POST["noEmpFirma"];
$pwdEmpFirma= $_POST["pwdEmpFirma"];
$idTarjeta  = $_POST["idTarjeta"];
$usuario   =$_SESSION ["userLog"]["usuario"];
$response["status"] = "success";
   
    $sql= "UPDATE tarjetadespensa 
            SET IdEstatusAsignacionEmpleado='0',idEstatusTarjeta='4', NumeroFirmaBajaTarjeta='$noEmpFirma', ContraseniaFirmaBajaTarjeta=md5('$pwdEmpFirma'),UsuarioBajaTarjeta='$usuario',FechaBajaTarjeta=now(),ComentarioBajaTarjeta='Tarjeta Despensa dada de baja desde Solicitud Bajas'
            WHERE IdTarjetaDespensa='$idTarjeta'";      
//$log->LogInfo("Valor de la variable sql: " . var_export ($sql, true));
        
    $res = mysqli_query($conexion, $sql);
    
    if($res !== true){
       $response["status"] ="error";
       $response["mensaje"]='error al actualizar datos de tarjeta despensa ajax_DarDBajaTarjetabySolicitudBaja';
    }
echo json_encode($response);
?> 