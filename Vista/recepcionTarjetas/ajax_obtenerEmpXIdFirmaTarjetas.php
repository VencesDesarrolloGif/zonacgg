<?php
session_start();
require_once("../../libs/logger/KLogger.php");
require "../conexion.php";
$response = array("status" => "success");
$datos= array ();
//$log = new KLogger ( "ajax_obtenerEmpXIdFirmaTarjetas.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable datosUsuario: " . var_export ($datosUsuario, true));
if(!empty ($_POST)){
	$empleadoId=$_POST['numeroEmpleado'];
	$empleadoidd = explode("-", $empleadoId);
    $empleadoEntidad=$empleadoidd[0];
    $empleadoConsecutivo=$empleadoidd[1];
    $empleadoCategoria=$empleadoidd[2];
	try{
        $sql = "SELECT * FROM firmainterna
        where EntidadFirma=$empleadoEntidad
        and  ConsecutivoFirma=$empleadoConsecutivo 
        and CategoriaFirma=$empleadoCategoria"; 

    $res = mysqli_query($conexion, $sql);
           while(($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
           }
			$response["empleado"]= $datos;	
	}catch(Exception $e ){
		   $response["status"]="error";
		   $response["error"]="No se puedo obtener Empleado";
	}
}

echo json_encode($response);

?>