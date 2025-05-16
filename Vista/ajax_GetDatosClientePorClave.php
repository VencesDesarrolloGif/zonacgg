<?php
session_start();
require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
$negocio= new Negocio();
verificarInicioSesion ($negocio);
$response = array("status" => "success");
if(!empty ($_POST)){
   // $log = new KLogger ( "ajax_GetDatosClientePorClave.log" , KLogger::DEBUG );
    //$log->LogInfo("Valor de la variable claveNomina " . var_export ($claveNomina, true));
    $claveNomina = getValueFromPost ("claveNomina");
    try{
        $DatosCliente = $negocio -> negocio_TraerDatosClientesPorClave($claveNomina,"","","1");
        $LargoArrayDatos = count($DatosCliente); 
        $response ["datos"] = $DatosCliente;
    }
    catch (Exception $e){
        $response ["status"] = "error";
        $response ["message"] = "No se pudieron obtener direcciones";
    }
}
echo json_encode ($response);
?>