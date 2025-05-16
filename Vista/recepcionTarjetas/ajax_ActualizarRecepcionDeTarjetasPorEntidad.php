<?php
session_start ();
require_once ("../../libs/logger/KLogger.php");
require "../conexion.php";
//$log = new KLogger ( "ajax_ActualizarRecepcionDeTarjetasPorEntidad.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));
$response= array();
$response["status"]           = "success";
$tarjetaAEnviarARecibirEnEntidad  = $_POST["tarjetaAEnviarARecibirEnEntidad"];
$NumEmpModalFirmaParaEntidad  = $_POST["NumEmpModalFirmaParaEntidad"];
$constraseniaFirmaParaEntidad = $_POST["constraseniaFirmaParaEntidad"];
$usuario                      = $_SESSION ["userLog"]["usuario"];
$EstatusAsignacion            = "1";
try{
    for ($i = 0; $i < count($tarjetaAEnviarARecibirEnEntidad); $i++){
        $IdTarjetaDespensa = $tarjetaAEnviarARecibirEnEntidad[$i];
        //$log->LogInfo("Valor de la variable IdTarjetaDespensa: " . var_export ($IdTarjetaDespensa, true));

        $sql = "UPDATE TarjetaDespensa 
            SET idEstatusAsignacionEntidad='$EstatusAsignacion',NumeroFirmaReciboAEntidad='$NumEmpModalFirmaParaEntidad',ContraseniaFirmaReciboAentidad='$constraseniaFirmaParaEntidad',UsuarioRecibioAEntidad='$usuario',FechaRecepcionAentidad=now()
            WHERE IdTarjetaDespensa='$IdTarjetaDespensa'";
    
        $res = mysqli_query($conexion, $sql);  
        if ($res !== true) {
            $response["status"] = "error";
            $response["message"]='error al enviar la petición ';
            return;
        }else{
            $response["message"]='Se envió correctamente la petición';
        }
    }
}catch (Exception $e) {
    $response["message"] = "Error al iniciar sesion";
    $response["status"] = "error";
}

echo json_encode($response);
?> 