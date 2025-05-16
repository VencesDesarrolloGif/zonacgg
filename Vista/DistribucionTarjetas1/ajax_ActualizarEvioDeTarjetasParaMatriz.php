<?php
session_start ();
require_once ("../../libs/logger/KLogger.php");
require "../conexion.php";
//$log = new KLogger ( "ajax_ActualizarEvioDeTarjetasParaMatriz.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));
$response                     = array();
$response["status"]           = "success";
$tarjetaAEnviarAMatriz        = $_POST["tarjetaAEnviarAMatriz"];
$IdMatriz                     = $_POST["IdMatriz"];
$NumEmpModalFirmaParaEntidad  = $_POST["NumEmpModalFirmaParaEntidad"];
$constraseniaFirmaParaEntidad = $_POST["constraseniaFirmaParaEntidad"];
$usuario                      = $_SESSION ["userLog"]["usuario"];
$EstatusAsignacion            = "3";
//$log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));
try{
    for ($i = 0; $i < count($tarjetaAEnviarAMatriz); $i++){
        $IdTarjetaDespensaParaMatriz = $tarjetaAEnviarAMatriz[$i];
        $sql = "UPDATE TarjetaDespensa 
            SET idEstatusAsignacionEntidad='$EstatusAsignacion',NumeroFirmaMandoAMatriz='$NumEmpModalFirmaParaEntidad',ContraseniaFirmaMandoAMatriz='$constraseniaFirmaParaEntidad',UsuarioMandoAMatriz='$usuario',FechaEnvioAMatriz=now()
            WHERE IdTarjetaDespensa='$IdTarjetaDespensaParaMatriz'";
    
        //$log->LogInfo("Ejecutando matricesEntidades: " . $sql);
        
        $res = mysqli_query($conexion, $sql);  
        if ($res !== true) {
            $response["status"] = "error";
            $response["message"]='error al enviar la petición ';
            return;
        }else{
            //se actualiza asistencia
            $response["message"]='Se envió correctamente la petición';
        }
        //$log->LogInfo("Valor de la variable response: " . var_export ($response, true));
    }
}catch (Exception $e) {
    $response["message"] = "Error al iniciar sesion";
    $response["status"] = "error";
}

echo json_encode($response);
?> 