<?php
session_start ();
require_once ("../../libs/logger/KLogger.php");
require "../conexion.php";
$log = new KLogger ( "ajax_ActualizarEvioDeTarjetas.log" , KLogger::DEBUG );
$log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));  
$response= array();
$response["status"]           = "success";
$tarjetaAEnviarParaEnEntidad  = $_POST["tarjetaAEnviarParaEnEntidad"];
$entidadAEnviar               = $_POST["entidadAEnviar"];
$NumEmpModalFirmaParaEntidad  = $_POST["NumEmpModalFirmaParaEntidad"];
$constraseniaFirmaParaEntidad = $_POST["constraseniaFirmaParaEntidad"];
$usuario                      = $_SESSION ["userLog"]["usuario"];
$EstatusAsignacion            = "2";
//$log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));
try{
    for ($i = 0; $i < count($tarjetaAEnviarParaEnEntidad); $i++){
        $IdTarjetaDespensa = $tarjetaAEnviarParaEnEntidad[$i];
        $log->LogInfo("Valor de la variable IdTarjetaDespensa: " . var_export ($IdTarjetaDespensa, true));
        $sql = "UPDATE TarjetaDespensa 
            SET idEstatusAsignacionEntidad='$EstatusAsignacion',idEntidadAsignada='$entidadAEnviar',NumeroFirmaAsignoAEntidad='$NumEmpModalFirmaParaEntidad',ContraseniaFirmaAsignoAentidad='$constraseniaFirmaParaEntidad',usuarioQueAsigno='$usuario',FechaASignacionentidad=now()
            WHERE IdTarjetaDespensa='$IdTarjetaDespensa'";
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