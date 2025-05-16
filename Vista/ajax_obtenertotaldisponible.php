<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");

$negocio = new Negocio();
verificarInicioSesion ($negocio);
//$datos=array();
$idbanco=$_POST["idbanco"];
$idnumcuenta=$_POST["idnumcuenta"];
$accion=$_POST["accion"];



$response = array("status" => "success");

if (!empty ($_POST))
{
//$log = new KLogger ( "ajaxTotaldisponible.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable \$montoFormato: " . var_export ($montoFormato, true));
    try
    {
        if($accion==0){
        $datos=$negocio -> negocio_cargosiniciales($idbanco);
       
    }
//$log->LogInfo("Valor de la variable \$_POST: " . var_export ($datos, true));
    elseif($accion==1){
$datos=$negocio ->negocio_ListaSaldosPorCuentas($idbanco,$idnumcuenta);

    }
     $response ["status"] = "success";
        $response ["datos"] =$datos;
}
    catch (Exception $e)
    {
        $response ["status"] = "error";
        $response ["message"] =  $e -> getMessage ();
    }

}
else
{
    $response ["status"] = "error";
    $response ["message"] = "No se proporcionaron datos";
}

echo json_encode ($response);
?>