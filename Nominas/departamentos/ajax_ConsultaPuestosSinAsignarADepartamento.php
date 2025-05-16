<?php
require "../conexion/conexion.php";
require_once("../logger/KLogger.php");
$response           = array();
$response["status"] = "error";
$datos              = array();
// $log = new KLogger ( "ajax_ConsultaPuestosSinAsignarADepartamento.log" , KLogger::DEBUG );
$categoriaPuesto= $_POST['categoria'];
$lineaNegocio   = $_POST['lineaNegocio'];

try {
    $sql = "SELECT catalogopuestos.idPuesto,descripcionPuesto
            FROM  catalogopuestos
            LEFT JOIN relacionPuestosDepartamentos on (relacionPuestosDepartamentos.idPuesto=catalogopuestos.idPuesto)
            WHERE (relacionPuestosDepartamentos.idRelacion is null or relacionPuestosDepartamentos.idRelacion = '')
            AND puestoIdCategoria = '$categoriaPuesto'
            AND puestoLineaNegocioId = '$lineaNegocio'
            ORDER BY descripcionPuesto";
    $res = mysqli_query($conexion, $sql);

    while(($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
           $datos[] = $reg;
    }
    //$log->LogInfo("Valor de variable datos" . var_export ($datos, true));
    $response["status"] = "success";
    $response["datos"]  = $datos;
}catch(Exception $e){
       $response["message"] = "Error al iniciar sesion";
}
echo json_encode($response);