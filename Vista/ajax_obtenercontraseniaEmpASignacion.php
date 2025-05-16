<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion ($negocio);
$response = array("status" => "success");
//$log = new KLogger ( "ajax_obtenercontraseniaEmpAsignacion.log" , KLogger::DEBUG );
if(!empty ($_POST))
{
	$contrasenia=getValueFromPost("contrasenia");
	$numEmpleado=getValueFromPost("numEmpleado");
	$empleadoidd = explode("-", $numEmpleado);
    $empleadoEntidad=$empleadoidd[0];
    $empleadoConsecutivo=$empleadoidd[1];
    $empleadoCategoria=$empleadoidd[2];
    $UsuarioEmpleado = $empleadoEntidad . $empleadoConsecutivo . $empleadoCategoria;
    $constraseniaCifrada = md5($contrasenia);
	$usuario = $_SESSION ["userLog"]["usuario"];
//	$log->LogInfo("Valor de la variable constraseniaCifrada: " . var_export ($constraseniaCifrada, true));
	try{
		$datosUsuario = $negocio -> obtenercontraseniaEmpAsignacion($UsuarioEmpleado);
		$conteoDatos = count($datosUsuario);
		if($conteoDatos =="0"){
			$response["status"]="error"; 
			$response["menssaje"]="El elemnto no cuenta con una contraseña generada favor de activar su cuanta en el siguiente link";
		}else {
			$contraseniaBase = $datosUsuario[0]["contrasenia"];
			if($contraseniaBase != $constraseniaCifrada){
				$response["status"]="error"; 
				$response["menssaje"]="La Contraseña ingresada es incorrecta, si no recuerda cual es favor de actualizarla en el siguiente link";
			}else{
				$response["status"]="success"; 
				$response["empleado"]= $datosUsuario;
			}
		}
	} 
	catch( Exception $e )
	{
		$response["status"]="error";
		$response["error"]="No se puedo obtener los datos Del Elemento favor De intentar nuevamente";
	}
}

echo json_encode($response);

?>