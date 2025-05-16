<?php
session_start();
require "conexion.php"; 
require_once("../libs/logger/KLogger.php");
// $log = new KLogger ( "ajax_insertHistoricoCambioPS.log" , KLogger::DEBUG );

$response= array();

$entidadEmp = $_POST["entidadEmp"];
$consecutivoEmp = $_POST["consecutivoEmp"];
$categoriaEmp = $_POST["categoriaEmp"];

$psActual= $_POST["psActual"];
$psNuevo = $_POST["psNuevo"];

$noEmpFirmaCambio = $_POST["NumEmpModalBaja"];
$pwdFirmaCambio = $_POST["constraseniaFirma"];

$usuarioLog = $_SESSION ["userLog"]["usuario"];

try{

    $sql= "INSERT INTO historico_CambiosdePSEmpleados(entidadFederativaEmpCPS,consecutivoEmpCPS,categoriaEmpCPS,idPuntoAnterior,idPuntoNuevo,noEmpFirmaCambio,contraseniaEmpFirmaCambio,usuarioEmpFirma,fechaCambioPs,fechaHoraCambioPs)
           VALUES('$entidadEmp','$consecutivoEmp','$categoriaEmp','$psActual','$psNuevo','$noEmpFirmaCambio',md5('$pwdFirmaCambio'),'$usuarioLog',now(),now())";

    $res = mysqli_query($conexion, $sql);
        // $log->LogInfo("Valor de la variable $sql: " . var_export ($sql, true));
        
    $response["status"]  = "success";
} catch (Exception $e) {
    $response["status"]  = "error";
    $response["message"] = $e->getMessage();
}
echo json_encode($response);