<?php
session_start ();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
$negocio = new Negocio ();
verificarInicioSesion ($negocio);
//$log = new KLogger ( "ajaxGetTurnosExtrasFatiga.log" , KLogger::DEBUG ); 
//$log->LogInfo("Valor de variable session" . var_export ($_SESSION, true));  

$response = array("status" => "success");

if(!empty ($_POST))
{ 

        //$usuario = $_SESSION ["userLog"]["empleadoId"];
        $fecha1=getValueFromPost("fecha1");
        $fecha2=getValueFromPost("fecha2");
        $puntoservicio=getValueFromPost("puntoServicioId");
        $idplantillaPunto=getValueFromPost("idplantillaPunto");
        
        //$supervisorEntidad=substr($usuario, 0,2);
        //$supervisorConsecutivo=substr($usuario, 3,4);
        //$supervisorTipo=substr($usuario, 8,2);

        //$log->LogInfo("Valor de variable de fecha1" . var_export ($fecha1, true));
        //$log->LogInfo("Valor de variable de fecha2" . var_export ($fecha2, true));
        
try{

        $lista= $negocio -> getTurnosExtrasFatigaPlantilla($fecha1,$fecha2, $puntoservicio,$idplantillaPunto);
       // $log->LogInfo("Valor de variable de lista" . var_export ($lista, true));
        $response["lista"]= $lista;

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