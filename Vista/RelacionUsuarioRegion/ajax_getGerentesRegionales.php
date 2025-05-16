<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$datos = array();
$response = array("status" => "success");
// $log = new KLogger ( "ajax_getGerentesRegionales.log" , KLogger::DEBUG );
// $log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));
try {
    $usuariosAsignados= array();
    $region= $_POST['region'];
    $lineaDeNegocio= $_POST['lineaDeNegocio'];

    $sql1 = "SELECT rur.idUsuario, u.usuario
             FROM relacionUsuarios_regiones rur
             LEFT JOIN usuarios u on u.usuarioId=rur.idUsuario
             WHERE idRegionI='$region'
             AND idLineaNegocioRUR='$lineaDeNegocio'"; 

    // $log->LogInfo("Valor de la variable sql1 " . var_export ($sql1, true));

    $res1 = mysqli_query($conexion, $sql1);
    while (($reg1 = mysqli_fetch_array($res1, MYSQLI_ASSOC))){
        $usuariosAsignados[] = $reg1;
    }

    if($usuariosAsignados==NULL || $usuariosAsignados=="NULL") {
       $totalUsuarios=0;
    }else{
        $totalUsuarios=count($usuariosAsignados);
    }

    $sql = "SELECT u.usuarioId,ue.usuario, concat_ws(', ', concat_ws('-',entidadEmpleadoUsuario, consecutivoEmpleadoUsuario, categoriaEmpleadoUsuario),concat_ws(' ',e.nombreEmpleado, e.apellidoPaterno, e.apellidoMaterno)) as noYnombreEmp
            FROM usuarios u
            LEFT JOIN usuario_empleado ue on ue.usuario=u.usuario
            LEFT JOIN empleados e on e.entidadFederativaId=ue.entidadEmpleadoUsuario AND e.empleadoConsecutivoId=ue.consecutivoEmpleadoUsuario AND e.empleadoCategoriaId=ue.categoriaEmpleadoUsuario
            WHERE (usuarioRolId='37' or usuarioRolId='41')
            AND (empleadoEstatusId='1' or empleadoEstatusId='2')";  

    if($totalUsuarios>0) {

        for($a=0; $a < $totalUsuarios; $a++){ 
            $usuarioID = $usuariosAsignados[$a]["idUsuario"];

            $suma= $a+1;

            if($a==0){
               $sql.=" AND (";
            }

            $sql.="usuarioId!=$usuarioID";

            if($suma==$totalUsuarios) {
               $sql.=")";
            }else{
               $sql.=" AND ";
            }
        }
        
        $sql.=" order by ue.usuario";

    }   
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
