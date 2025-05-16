<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response                     = array();
$response["status"]           = "error";
$NumEmpModalBaja              = $_POST["NumEmpModalBaja"];
$constraseniaFirma            = $_POST["constraseniaFirma"];
//$usuario                      = $_SESSION ["userLog"]["usuario"];
$datos                        = array();
//$log = new KLogger ( "ajax_obtenerFirmaSolicitada.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable _SESSION " . var_export ($_SESSION, true));
try {
        $sql = "SELECT * FROM firmainterna fi
                left join empleados em on (fi.EntidadFirma =em.entidadFederativaId and fi.ConsecutivoFirma=em.empleadoConsecutivoId and fi.CategoriaFirma=em.empleadoCategoriaId)
                where concat_ws('-',fi.EntidadFirma,fi.ConsecutivoFirma,fi.CategoriaFirma)='$NumEmpModalBaja'
                    and ContraseniaFirma=md5('$constraseniaFirma')";      
        $res = mysqli_query($conexion, $sql);
        while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
        }
//$log->LogInfo("Valor de la variable datos " . var_export ($datos, true));

    $response["status"]= "success";
    $response["datos"] = $datos;
}catch (Exception $e) {
    $response["mensaje"] = "Error al Obtener Matrices";}
echo json_encode($response);
