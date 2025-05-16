<?php
session_start ();
require_once ("../../libs/logger/KLogger.php");
require "../conexion.php";
//$log = new KLogger ( "ajax_ActualizarRecepcionDeTarjetasMatrizR.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));
$response= array();
$response["status"]           = "success";
$tarjetaARecibirEnMatriz      = $_POST["tarjetaARecibirEnMatriz"];
$NumEmpModalFirmaParaEntidad  = $_POST["NumEmpModalFirmaParaEntidad"];
$constraseniaFirmaParaEntidad = $_POST["constraseniaFirmaParaEntidad"];
$usuario                      = $_SESSION ["userLog"]["usuario"];
$EstatusAsignacion            = "0";

try{
    for ($i = 0; $i < count($tarjetaARecibirEnMatriz); $i++){
        $IdTarjetaDespensa = $tarjetaARecibirEnMatriz[$i];
        $sql = "UPDATE TarjetaDespensa 
            SET idEstatusAsignacionEntidad='$EstatusAsignacion',NumeroFirmaRecibeAMatriz='$NumEmpModalFirmaParaEntidad',ContraseniaFirmaRecibeAMatriz='$constraseniaFirmaParaEntidad',UsuarioRecibeAMatriz='$usuario',FechaRecepcionAMatriz=now()
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