<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion ($negocio);
//$log = new KLogger ( "ajaxObtenerEventuales.log" , KLogger::DEBUG );

$response = array("status" => "success");
$userRol=$_SESSION ["userLog"]["rol"];

try{
	//$log->LogInfo("Valor de la variable \$userRol: " . var_export ($userRol, true));

	if($userRol== 'Supervisor' || $userRol== 'Consulta Supervisor'){
		$lista= $negocio -> negocio_traerEventualesTableSup($_SESSION ["userLog"]["usuario"]);
	}else{
		$lista= $negocio -> negocio_traerEventualesTable();
	}
	
	for($i=0;$i<count($lista);$i++){
		$idEventual=$lista[$i]["idServicioEventual"];
		$folio=$lista[$i]["folioEventual"];
		$costo=$lista[$i]["costoEventual"];
		$cantidadElementos=$lista[$i]["numElementosEv"];
		$nombreEventual=$lista[$i]["nombreServicio"];		
		$lista[$i]["folioEventual"]="EV-".$folio;
		$nuevo="img/addMenu.png";
		$formato="img/contratos.png";
		$detalle="img/familyok.png";
		//$lista[$i]["costoEventual"]=money_format('$', $costo);
		if($costo!=""){
			$lista[$i]["costoEventual"]='$'.number_format($costo,2);
		    if($userRol=="Ventas"){
				$lista[$i]["costoEventual"]="<input class='input-mini' type='text' id='txtCosto".$idEventual."' value='".$costo."' name='txtCosto".$idEventual."' onkeypress='editarCosto(".$idEventual.",event);'>";
			}	
		}else{
			if($userRol=="Ventas"){
				$lista[$i]["costoEventual"]="<input class='input-mini' type='text' id='txtCosto".$idEventual."' name='txtCosto".$idEventual."' onkeypress='editarCosto(".$idEventual.",event);'>";
			}
		}
		if($userRol=="Supervisor" || $userRol=="Consulta Supervisor"){
			$lista[$i]["acciones"]="<a href='javascript:modalAsignarElemento(".$idEventual.",".$cantidadElementos.",\"".$nombreEventual."\");' ><img style='max-width: 300px; max-height: 300px' src='".$nuevo."' title='Asignar Elemento'></a>  ";		
			$lista[$i]["acciones"].="<a href='javascript:generarFormatoEventual(".$idEventual.");' ><img style='width: 20%;' src='".$formato."' title='Formato'></a>  ";
			$lista[$i]["acciones"].="<a href='#' ><img style='max-width: 300px; max-height: 300px' src='".$detalle."' title='Ver Elementos'></a>";
		}else if($userRol=="Ventas" || $userRol=="Analista Asistencia" || $userRol=="Facturacion"){			
			$lista[$i]["acciones"]="<a href='javascript:generarFormatoEventual(".$idEventual.");' ><img style='width: 20%;' src='".$formato."' title='Formato'></a>  ";
			$lista[$i]["acciones"].="<a href='#' ><img style='max-width: 300px; max-height: 300px' src='".$detalle."' title='Ver Elementos'></a>";
		}
	}
	$response["data"]= $lista;
	//$log->LogInfo("Valor de la variable \$lista: " . var_export ($lista, true));


} 
catch( Exception $e )
{
	$response["status"]="error";
	$response["error"]="No se pudo obtener la lista de Eventuales";
}

echo json_encode($response);

?>