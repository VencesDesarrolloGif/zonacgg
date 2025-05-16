<?php
session_start();
require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion ($negocio);
// $log = new KLogger ( "ajaxListaClientes.log" , KLogger::DEBUG ); 
// $log->LogInfo("Valor de la variable Post: " . var_export ($_POST, true));
$response = array("status" => "success");
$cons=getValueFromPost ("cons");
try{

	$listaClientes= $negocio -> negocio_obtenerListaClientes();
	if($cons !="1"){
		for ($i=0; $i < count($listaClientes) ; $i++) { 
			$claveCliente = $listaClientes[$i]["claveClienteNomina"];
			$direccionFiscalCliente1 = $listaClientes[$i]["direccionFiscalCliente"];
			$CallePrincipaCliente = $listaClientes[$i]["CallePrincipaCliente"];
			$NumeroExteriorCliente = $listaClientes[$i]["NumeroExteriorCliente"];
			$nombreAsentamiento = $listaClientes[$i]["nombreAsentamiento"];
			$CodigoPostalCliente = $listaClientes[$i]["CodigoPostalCliente"];
			$nombreMunicipio = $listaClientes[$i]["nombreMunicipio"];
			$nombreEntidadFederativa = $listaClientes[$i]["nombreEntidadFederativa"];
			$razonSocial = $listaClientes[$i]["razonSocial"];
			$nombreComercial = $listaClientes[$i]["nombreComercial"];
			if($CodigoPostalCliente == "NULL" || $CodigoPostalCliente == "null" || $CodigoPostalCliente == NULL || $CodigoPostalCliente == null || $CodigoPostalCliente == ""){
				$listaClientes[$i]["direccionFiscalCliente1"] = $direccionFiscalCliente1; 
			}else{
				$listaClientes[$i]["direccionFiscalCliente1"] = "".$nombreComercial.", ".$CallePrincipaCliente." ".$NumeroExteriorCliente.", ".$nombreAsentamiento.", ".$CodigoPostalCliente." ".$nombreMunicipio.", ".$nombreEntidadFederativa."	";
			}

			$listaClientes[$i]["editarCliente"] = "<img style='width:24%' title='Editar Cliente' src='img/clients.png' class='cursorImg' id='btnCLienteEdit' onclick=EditarContratosInicialesEDIT('$claveCliente',2)> ";
			$listaClientes[$i]["editarContrato"]= "<img style='width:24%' title='Editar Contrato'src='img/edit.png' class='cursorImg' id='btnPapeleta' onclick=EditarContratosInicialesEDIT('$claveCliente',0)> ";
			$listaClientes[$i]["nuevoContrato"] = "<img style='width:24%' title='Agregar un nuevo contrato' src='img/addMenu.png' class='cursorImg' onclick=abrirModalFirmaNuevoContrato('$claveCliente',1)> ";
		}
	}
	$response["listaClientes"]= $listaClientes;
} 
catch( Exception $e ){
	$response["status"]="error";
	$response["error"]="No se puedo obtener Lista de Clientes";
}
echo json_encode($response);
?>