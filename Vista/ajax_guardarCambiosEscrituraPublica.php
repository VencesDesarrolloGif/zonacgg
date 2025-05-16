<?php
session_start();
require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();
verificarInicioSesion($negocio);
$response = array("status" => "success");
//$log = new KLogger ( "ajax_guardarCambiosEscrituraPublica.log" , KLogger::DEBUG );

$RepresentanteLegal 	 = $_POST['RepresentanteLegal'];
$AdministradorUnico 	 = $_POST['AdministradorUnico'];
$NumeroEscritura 		 = $_POST['NumeroEscritura'];
$NombreNotarioPublico = $_POST['NombreNotarioPublico'];
$NumeroNotarioPublico = $_POST['NumeroNotarioPublico'];
$FechaEscrituraPublica= $_POST['FechaEscrituraPublica'];
$FolioMercantil 		 = $_POST['FolioMercantil'];
$nombreDocumento 		 = 'aquivaDopcumento';

   try{
    	 $escrituraPublica = $negocio->updateDatosEscrituraPublica($RepresentanteLegal,$AdministradorUnico,$NumeroEscritura,$NombreNotarioPublico,$NumeroNotarioPublico,$FechaEscrituraPublica,$FolioMercantil,$nombreDocumento);// se inserta ya que no se deben sobreescribir los datos

   	 //$log->LogInfo("Valor de response" . var_export ($response, true));
    	 
   } 
	catch (Exception $e) {
	    $response["status"] = "error";
	    $response["error"]  = "No se puedo obtener lista de Marcas";
	}
echo json_encode($response);
