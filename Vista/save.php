<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion ($negocio);
// $log = new KLogger ( "save.log" , KLogger::DEBUG );

$response = array("status" => "success");

if(!empty ($_POST))
{


        //$estatusEmpleado=getValueFromPost("estatusEmpleado");

        //$numeroEmpleado=getValueFromPost("numeroEmpleado");
        $imgData=getValueFromPost("imgData");

          $entidad=getValueFromPost("empleadoEntidad");
          $consecutivo=getValueFromPost("empleadoConsecutivo");
          $tipo=getValueFromPost("empleadoTipo");

        //$log->LogInfo("Valor de variable de numeroEmpleado" . var_export ($numeroEmpleado, true));
        // $log->LogInfo("Valor de variable de imgData" . var_export ($imgData, true));
        
    try{

  //$numeroEmpleado=$GLOBALS['HTTP_RAW_POST_DATA'];


  $filteredData=substr($imgData, strpos($imgData, ",")+1);



  // $log -> LogInfo ("filteredData ".var_export ($filteredData, true));

  $unencodedData=base64_decode($filteredData);
  // $log -> LogInfo ("unencodedData ".var_export ($unencodedData, true));

  $numeroEmpleado=$entidad."-".$consecutivo."-".$tipo;
  // $log -> LogInfo ("numeroEmpleado ".var_export ($numeroEmpleado, true));


  $name=sha1(basename($numeroEmpleado)) . ".png";

  $fp = fopen("uploads/firmas/".$name."", "wb" );
  fwrite( $fp, $unencodedData);
  fclose( $fp );

$negocio -> actualizaFirmaEmpleado($entidad,$consecutivo,$tipo,$name);
     $response["message"]="Firma guardada";
        

    } 
    catch( Exception $e )
    {
    $response["status"]="error";
    $response["error"]="No se pudo guardar la firma";
    }

}
else
{
    $response ["status"] = "error";
    $response ["message"] = "No se proporcionaron datos";
}


echo json_encode($response);

?>
