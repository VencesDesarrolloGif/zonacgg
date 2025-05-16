<?php
session_start();
require_once("../libs/logger/KLogger.php");
require "conexion.php";
$response = array("status" => "success");
$datos= array ();
$noEmpFirma= $_POST['noEmpFirma'];
$pwdEmpFirma= $_POST['pwdEmpFirma'];
// $log = new KLogger ( "ajax_RevisarFirmaEmpleado.log" , KLogger::DEBUG );
// $log->LogInfo("Valor de la variable sql: " . var_export ($sql, true));
// $log->LogInfo("Valor de la variable sql1: " . $sql);

try{
    $sql = "SELECT * FROM firmainterna fi
            left join empleados em on (fi.EntidadFirma =em.entidadFederativaId and fi.ConsecutivoFirma=em.empleadoConsecutivoId and fi.CategoriaFirma=em.empleadoCategoriaId)
            where concat_ws('-',fi.EntidadFirma,fi.ConsecutivoFirma,fi.CategoriaFirma)='$noEmpFirma'
            and ContraseniaFirma=md5('$pwdEmpFirma')"; 

    $res = mysqli_query($conexion, $sql);
           while(($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
           }
           $response ["datos"] = $datos;
}catch (Exception $e){
    $response ["status"] = "error";
    $response ["message"] = "error al verificar la firma interna"; 
}

echo json_encode ($response);
?>