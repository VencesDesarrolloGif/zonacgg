 <?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion ($negocio);
//$log = new KLogger ( "ajax_getCoberturaReporte.log" , KLogger::DEBUG );

$response = array("status" => "success");

if (!empty ($_POST))
{

	try{

	$month=getValueFromPost("month");
	$year=getValueFromPost("year");

	//$log->LogInfo("Valor de la variable \$month: " . var_export ($month, true));
	//$log->LogInfo("Valor de la variable \$year: " . var_export ($year, true));
	//$log->LogInfo("Valor de la variable \$idPuntoServicio: " . var_export ($idPuntoServicio, true));

	
	$lista= $negocio -> getEntidadesCobertura($month, $year);
	
	for ($i = 0; $i < count($lista); $i++)
    {
        $idEntidadFederativa = $lista [$i]["idEntidadFederativa"];
        //$puestoCubiertoId = $lista [$i]["puestoCubiertoId"];


    }
    

	$response["lista"]= $lista;


	
	//$log->LogInfo("Valor de la variable \$lista: " . var_export ($response, true));

	} catch( Exception $e )
	{
    	$response["status"]="error";
    	$response["error"]="No se puedo obtener datos";
	}

}else{
    $response ["status"] = "error";
    $response ["message"] = "No se proporcionaron datos";
}

echo json_encode($response);

?>