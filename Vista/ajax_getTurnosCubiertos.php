<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion ($negocio);
// $log = new KLogger ( "ajax_getTurnosCubiertos.log" , KLogger::DEBUG );

$response = array("status" => "success");

if(!empty ($_POST))
{

        //$usuario = $_SESSION ["userLog"]["empleadoId"];
        $fecha1=getValueFromPost("fecha1");
        $fecha2=getValueFromPost("fecha2");
        $idPuntoServicio=getValueFromPost("idPuntoServicio");

        //$log->LogInfo("Valor de variable de fecha1" . var_export ($fecha1, true));
        //$log->LogInfo("Valor de variable de fecha2" . var_export ($fecha2, true));
        //$log->LogInfo("Valor de variable de usuario" . var_export ($usuario, true));
       
try{

    $lista= $negocio -> getTurnosCubiertosRequisicion($fecha1,$fecha2, $idPuntoServicio);


    $response["lista"]= $lista;
    // $log->LogInfo("Valor de la variable \$listaEmpleados: " . var_export ($response, true));

} 
catch( Exception $e )
{
    $response["status"]="error";
    $response["error"]="No se puedo obtener consulta";
}
}
else
{
    $response ["status"] = "error";
    $response ["message"] = "No se proporcionaron datos";
}


echo json_encode($response);

?>