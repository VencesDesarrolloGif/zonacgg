<?php
session_start ();
require_once ("../../libs/logger/KLogger.php");
require "../conexion.php";
date_default_timezone_set('America/Mexico_City');
$response = array();
$datos    = array();
$response = array("status" => "success");
//$log = new KLogger ( "ajax_ObtenerListaSupervisoresXLinea.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));
try {
    $idLineaNegocio = $_POST ["idLineaNegocio"];
    $sql = "SELECT * FROM empleados e 
            left join usuario_empleado ue ON (e.entidadFederativaId=ue.entidadEmpleadoUsuario and e.empleadoConsecutivoId=ue.consecutivoEmpleadoUsuario and e.empleadoCategoriaId=ue.categoriaEmpleadoUsuario)
            left join usuarios u on (ue.usuario=u.usuario)
            where (e.empleadoEstatusId='1' or e.empleadoEstatusId='2')
            and e.empleadoLineaNegocioId='$idLineaNegocio'
            and u.usuarioRolId='11'
            and u.contrasenia!='BLOQUEO'";
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