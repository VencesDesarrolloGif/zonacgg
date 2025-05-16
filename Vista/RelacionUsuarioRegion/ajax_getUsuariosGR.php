<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$datos = array();
$response = array("status" => "success");
// $log = new KLogger ( "ajax_getUsuariosGR.log" , KLogger::DEBUG );

try {
    
    $sql = "SELECT u.usuarioId,ue.usuario, concat_ws(', ', concat_ws('-',entidadEmpleadoUsuario, consecutivoEmpleadoUsuario, categoriaEmpleadoUsuario),concat_ws(' ',e.nombreEmpleado, e.apellidoPaterno, e.apellidoMaterno)) as noYnombreEmp
            FROM usuarios u
            LEFT JOIN usuario_empleado ue on ue.usuario=u.usuario
            LEFT JOIN empleados e on e.entidadFederativaId=ue.entidadEmpleadoUsuario AND e.empleadoConsecutivoId=ue.consecutivoEmpleadoUsuario AND e.empleadoCategoriaId=ue.categoriaEmpleadoUsuario
            WHERE (usuarioRolId='37' or usuarioRolId='41')
            AND (empleadoEstatusId='1' or empleadoEstatusId='2')
            ORDER BY ue.usuario";  

    $res = mysqli_query($conexion, $sql);
    while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
        $datos[] = $reg;
    }

    for($i=0; $i < count($datos); $i++) { 
        $usuario=$datos[$i]["usuario"];
        $noYnombre=$datos[$i]["noYnombreEmp"];
        $descripcion=$usuario."(".$noYnombre.")";
        $datos[$i]["descripcion"]=$descripcion;
    }
    $response["datos"] = $datos;
} catch (Exception $e) {
    $response["status"] = "error";
    $response["error"]  = "No se puedo obtener lista de datos";
}
echo json_encode($response);
