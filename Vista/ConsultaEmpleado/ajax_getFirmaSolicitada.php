<?php
session_start ();
require_once ("../../libs/logger/KLogger.php");
require "../conexion.php";
date_default_timezone_set('America/Mexico_City');
$response = array();
$datos    = array();
$response = array("status" => "success");
//$log = new KLogger ( "ajax_getFirmaSolicitada.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));
$NumEmpModal=$_POST["NumEmpModalBaja"];
$constraseniaFirma=$_POST["constraseniaFirma"];
try {
    $sql = "SELECT * FROM firmainterna fi
            left join empleados em on (fi.EntidadFirma =em.entidadFederativaId and fi.ConsecutivoFirma=em.empleadoConsecutivoId and fi.CategoriaFirma=em.empleadoCategoriaId)
            where concat_ws('-',fi.EntidadFirma,fi.ConsecutivoFirma,fi.CategoriaFirma)='$NumEmpModal'
            and ContraseniaFirma=md5('$constraseniaFirma')";
        //$log->LogInfo("Ejecutando matricesEntidades  aaaa: " . $sql);           
    $res = mysqli_query($conexion, $sql);
    while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
        $datos[] = $reg;
    }
    $response["datos"]= $datos;
    //$log->LogInfo("Valor de la variable datos: " . var_export ($datos, true));
}catch (Exception $e) {    
    $response["status"]="error";
    $response["error"]="No se puedo obtener la contraseña de la firma";
}
echo json_encode($response);
?>