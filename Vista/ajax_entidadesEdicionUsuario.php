<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion ($negocio);
$response = array("status" => "success");
if(!empty ($_POST))
{
		//$log = new KLogger ( "ajaxobtenerUsersByEmpleado.log" , KLogger::DEBUG );
		$accion=getValueFromPost("accion");	
	try{
		if($accion==0){
			 $catalogoEntidadesFederativas = $negocio->negocio_obtenerListaEntidadesFeferativasParaAlmacen();
			 $response["entidadesFederativas"]= $catalogoEntidadesFederativas;

		}else if($accion==1){
				$empleadoId=getValueFromPost("numeroEmpleado");
				$miarrayEmp= explode("-", $empleadoId);
				$empleadoEntidad=$miarrayEmp[0];
				$empleadoConsecutivo=$miarrayEmp[1];
				$empleadoCategoria=$miarrayEmp[2];
				$UserByEmpleado= $negocio -> negocio_obtenerUsuariosEmpleado($empleadoEntidad, $empleadoConsecutivo, $empleadoCategoria);
			if(count($UserByEmpleado)==0){
				$response["status"]="error";
				$response["error"]="No Existe Número de Empleado";
				
			}
				$response["empleado"]= $UserByEmpleado;
		}else if($accion==2){
				$idusuario=getValueFromPost("idusuario");
				$EntidadesByUser= $negocio -> negocio_obtenerEntidadesByIdUser($idusuario);
				$response["entidades"]= $EntidadesByUser;

				$LineasNegocioByUser= $negocio -> negocio_obtenerLineasNegocioByIdUser($idusuario);
				$response["lineasnegocio"]= $LineasNegocioByUser;



		}else if($accion==3){

			$idusuario=getValueFromPost("idusuario");
			$identidad=getValueFromPost("identidad");
			$respuesta=$negocio -> negocio_EliminarEntidadUSer($idusuario,$identidad);
			

			//$log->LogInfo("Valor de variable de empleadoId que viene de form" . var_export ($respuesta, true));
		}else if($accion==4){

			$idusuario=getValueFromPost("idusuario");
			$identidad=getValueFromPost("identidad");
			$respuesta=$negocio -> negocio_addEntidadUSer($idusuario,$identidad);
			$response["status"]=$respuesta;
			//$log->LogInfo("Valor de variable de empleadoId que viene de form" . var_export ($respuesta, true));
		}else if($accion==5){

			$idusuario=getValueFromPost("idusuario");
			$idlineanegocio=getValueFromPost("idlineanegocio");
			$respuesta=$negocio -> negocio_EliminarLineaNegocioUSer($idusuario,$idlineanegocio);
			//$log->LogInfo("Valor de variable de empleadoId que viene de form" . var_export ($respuesta, true));
		}else if($accion==6){
			$catalogoLineasnegocio = $negocio->negocio_obtenerListaLineaNegocio();
			 $response["lineasnegocio"]= $catalogoLineasnegocio;
		}else if($accion==7){

			$idusuario=getValueFromPost("idusuario");
			$idlineanegocio=getValueFromPost("idlineanegocio");
			$respuesta=$negocio -> negocio_addLineaNegocioUSer($idusuario,$idlineanegocio);
			$response["status"]=$respuesta;
			//$log->LogInfo("Valor de variable de empleadoId que viene de form" . var_export ($respuesta, true));
		}
		//$log->LogInfo("Valor de variable de empleadoId que viene de form" . var_export ($response, true));
	}catch( Exception $e ){$response["status"]="error";$response["error"]="No se puedo obtener Empleado";}
}
echo json_encode($response);

?>