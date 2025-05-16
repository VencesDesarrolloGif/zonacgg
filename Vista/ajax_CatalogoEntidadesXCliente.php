<?php
session_start();
require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();
verificarInicioSesion($negocio);
$response = array("status" => "success");
//$log = new KLogger ( "ajax_catalogoEntidadesXCliente.log" , KLogger::DEBUG );
$ClienteElegido = getValueFromPost ("ClienteElegido");
$LineaNegocioElegida = getValueFromPost ("LineaNegocioElegida");

   try {
       if($_SESSION["userLog"]["rol"]=='Gerente Regional') {
           $casoXgerente='1';
           $entidadGerente = $_SESSION["userLog"]['entidadFederativaUsuario'][0];//para obtener su region
           $region = $negocio->obtenerRegionGerente($LineaNegocioElegida,$entidadGerente);//revisar aqui
           $regionGerente= $region[0]["idRegionI"];
         }else{
              $casoXgerente ='0';
              $regionGerente='0';
         }

        $entidades = $negocio->obtenerEntidadesXCliente($ClienteElegido,$casoXgerente,$regionGerente,$LineaNegocioElegida);
        $response["datos"] = $entidades;
    //$log->LogInfo("Valor de entidad" . var_export ($response, true));
   		}catch (Exception $e) 
   		      {
	    	   $response["status"] = "error";
	    	   $response["error"]  = "No se puedo obtener lista de Marcas";
			  }
echo json_encode($response);
