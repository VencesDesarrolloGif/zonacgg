<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response           = array();
$response["status"] = "error";
$datos              = array();
//$log = new KLogger ( "ajax_obtenerEmpleadoPorIdParaASignarMatriz.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable datos " . var_export ($datos, true));
if(!empty ($_POST)){
    $empleadoId = $_POST["numeroEmpleado"];
    $usuario=$_SESSION ["userLog"];  
    try {
        $empleadoidd = explode("-", $empleadoId);
        $empleadoEntidad=$empleadoidd[0];
        $empleadoConsecutivo=$empleadoidd[1];
        $empleadoCategoria=$empleadoidd[2];


        $sql = "SELECT * from empleados e
                left join catalogopuestos cp on (cp.idPuesto=e.empleadoIdPuesto)
                left join entidadesfederativas ef on (ef.idEntidadFederativa=e.idEntidadTrabajo)
                left join catalogolineanegocio cln on(e.empleadoLineaNegocioId=cln.idLineaNegocio)
                where e.entidadFederativaId='$empleadoEntidad'
                and e.empleadoConsecutivoId='$empleadoConsecutivo'
                and e.empleadoCategoriaId='$empleadoCategoria'";
                 //$log->LogInfo("Ejecutando matricesEntidades  insert: " . $sql);     

            $res = mysqli_query($conexion, $sql);
            while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
                $datos[] = $reg;
            }
    
        $response["status"]= "success";
        $response["datos"] = $datos;
    //$log->LogInfo("Valor de la variable response " . var_export ($response, true));
    }catch (Exception $e) {
        $response["mensaje"] = "Error al Obtener Matrices";}
}
echo json_encode($response);
