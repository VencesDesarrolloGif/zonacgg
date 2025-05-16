<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();
  
// $log = new KLogger ( "ajax_getAsistenciaByGuardiaIdAndFecha.log" , KLogger::DEBUG );

$response = array("status" => "success");
$caso=getValueFromPost("caso");
$listaEmpleados1 = array();
$AsistenciaApp = array();
try{

    if($caso == "1"){

        $correo=getValueFromPost("correo");
        $listaEmpleados= $negocio -> getEmpleadoByCorreo($correo);
        for ($i = 0; $i < count($listaEmpleados); $i++)
        {
        
            $numeroEmpleado=$listaEmpleados[$i]["numeroEmpleado"];

            $descripcionTipoPeriodo=$listaEmpleados[$i]["descripcionTipoPeriodo"];
            $diasAsistencia= $negocio -> obtenerListaDiasParaAsistencia ($descripcionTipoPeriodo);
        
            $fecha1=$diasAsistencia[0]["fecha"];
            $fecha2=$diasAsistencia[count($diasAsistencia)-1]["fecha"];
            $response["fecha1"] = $fecha1;
            $response["fecha2"] = $fecha2;
        
            $listaEmpleados1 = $negocio -> getAsistenciaByEmpleadoIdPeriodo ($fecha1, $fecha2, $numeroEmpleado);
            $AsistenciaApp = $negocio -> getAsistenciaApp ($fecha1, $fecha2, $numeroEmpleado);
           $i=count($listaEmpleados);
           $response["listaEmpleados"] = $listaEmpleados;
           }
    }else{
        $fecha1=getValueFromPost("fecha1");
        $fecha2=getValueFromPost("fecha2");
        $numeroEmpleado=getValueFromPost("numeroEmpleado");
        $listaEmpleados1= $negocio -> getAsistenciaByEmpleadoIdPeriodo ($fecha1, $fecha2, $numeroEmpleado);
        $AsistenciaApp = $negocio -> getAsistenciaApp ($fecha1, $fecha2, $numeroEmpleado);
    }
    
    
    $response["asistenciaEmpleado"] = $listaEmpleados1;
    $response["AsistenciaApp"] = $AsistenciaApp;
    // $log->LogInfo("Valor de la variable listaEmpleados: " . var_export ($response, true));

} 
catch( Exception $e )
{
    $response["status"]="error";
    $response["error"]="No se puedo obtener consulta";
    $response ["message"] =  $e -> getMessage ();
}


echo json_encode($response);

?>