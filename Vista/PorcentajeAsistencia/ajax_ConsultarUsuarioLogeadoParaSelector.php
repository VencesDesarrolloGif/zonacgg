<?php
session_start ();
require_once ("../../libs/logger/KLogger.php");
require "../conexion.php";
date_default_timezone_set('America/Mexico_City');
$response = array();
$datos    = array();
$response = array("status" => "success");
$log = new KLogger ( "ajax_ConsultarUsuarioLogeadoParaSelector.log" , KLogger::DEBUG );
$log->LogInfo("Valor de la variable _SESSION: " . var_export ($_SESSION, true));
//$usuario = $_SESSION ["userLog"]["usuario"];
try {
    $usuarioRol = $_SESSION ["userLog"]["rol"];
    if($usuarioRol != 'Supervisor' && $usuarioRol != "Supervisor"){
        $sql = "SELECT concat_ws('-',entidadFederativaId,empleadoConsecutivoId,empleadoCategoriaId) as NumSupervisor,concat_ws(' ',nombreEmpleado,apellidoPaterno,apellidoMaterno) as NombreSupervisor 
                from empleados
                where (empleadoIdPuesto ='6' or empleadoIdPuesto ='61' or empleadoIdPuesto ='88' or empleadoIdPuesto ='116')
                and empleadoEstatusId != '0'
                order by NombreSupervisor";
        $res = mysqli_query($conexion, $sql);
        while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
        }
        $response["datos"]= $datos;
        $response["NumeroSup"]= "0";

    }else{
        $usuarioNumero = $_SESSION ["userLog"]["empleadoId"];
        $response["datos"]= "0";
        $response["NumeroSup"]= $usuarioNumero;

    }     
}catch (Exception $e) {    
    $response["status"]="error";
    $response["error"]="No se puedo obtener la lista de supervisores";
}
echo json_encode($response);
?>