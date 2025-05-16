<?php
session_start();
require_once("../../libs/logger/KLogger.php");
require "../conexion.php";
$response = array("status" => "success");
$datos= array ();
//$log = new KLogger ( "ajax_ObtenerSucursalesPorEntidadParaRecepcion.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable datosUsuario: " . var_export ($datosUsuario, true));
if(!empty ($_POST)){
	$EntidadABuscar=$_POST['EntidadABuscar'];
	try{
        $sql = "SELECT * FROM sucursalesinternas
                where idEntidadPerteneciente='$EntidadABuscar'
                and estatusSucursalI='1';"; 

    $res = mysqli_query($conexion, $sql);
           while(($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
           }
			$response["datos"]= $datos;	
	}catch(Exception $e ){
		   $response["status"]="error";
		   $response["error"]="No se puedo obtener Empleado";
	}
}

echo json_encode($response);

?>