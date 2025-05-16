<?php
session_start ();
require_once ("../../libs/logger/KLogger.php");
require "../conexion.php";
date_default_timezone_set('America/Mexico_City');
$response = array();
$datos    = array();
$response = array("status" => "success");
//$log = new KLogger ( "ajax_ConsultasXTipo.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));
$tipo= $_POST['tipo'];
$lineaNegocio= $_POST['lineaNegocio'];

try {
    if($tipo=='2'){
        $sql = "SELECT idCliente as idTipo,razonSocial as descTipo
                FROM catalogoclientes
                WHERE estatusCliente='1'
                ORDER BY razonSocial";
    }if($tipo=='3'){
        $sql = "SELECT idEntidadFederativa as idTipo,nombreEntidadFederativa as descTipo
                FROM entidadesfederativas
                WHERE idEntidadFederativa!=33 AND idEntidadFederativa!=50";
    }/*if($tipo='4'){
        $sql = "SELECT entidadFederativaId,empleadoConsecutivoId,empleadoCategoriaId
                FROM empleados e
                LEFT JOIN catalogopuestos cp ON cp.idPuesto=e.empleadoIdPuesto";

                if ($lineaNegocio=='1') {
                    $sql.=" WHERE empleadoIdPuesto='6'";
                }
                if ($lineaNegocio=='2') {
                    $sql.=" WHERE empleadoIdPuesto='61'";
                }
                if ($lineaNegocio=='3') {
                    $sql.=" WHERE empleadoIdPuesto='88'";
                }
    }*/
        //$log->LogInfo("Ejecutando matricesEntidades  aaaa: " . $sql);           
    $res = mysqli_query($conexion, $sql);
    while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
        $datos[] = $reg;
    }
    $response["datos"]= $datos;
    //$log->LogInfo("Valor de la variable datos: " . var_export ($datos, true));
}catch (Exception $e) {    
    $response["status"]="error";
    $response["error"]="No se puedo obtener Lista se Entidades";
}
echo json_encode($response);
?>